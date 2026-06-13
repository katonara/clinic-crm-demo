<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $appointments = $this->filtered($request)
            ->orderByDesc('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(15)
            ->withQueryString();

        return view('admin.appointments', [
            'appointments' => $appointments,
            'statuses' => Appointment::STATUSES,
            'currentStatus' => $request->query('status'),
            'currentDate' => $request->query('date'),
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', Appointment::STATUSES)],
        ]);

        $appointment->update(['status' => $validated['status']]);

        // Notify the patient on meaningful status changes.
        if (in_array($validated['status'], ['confirmed', 'completed', 'cancelled'], true)) {
            $appointment->loadMissing(['user', 'service']);
            Mail::to($appointment->user->email)->send(new AppointmentMail($appointment, $validated['status']));
        }

        return back()->with('status', "Appointment #{$appointment->id} marked as {$validated['status']}.");
    }

    /**
     * Stream the (filtered) appointments as a CSV download.
     */
    public function export(Request $request): StreamedResponse
    {
        $appointments = $this->filtered($request)
            ->with(['user', 'service'])
            ->orderByDesc('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $filename = 'appointments-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($appointments) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Patient', 'Email', 'Phone', 'Service', 'Date', 'Time', 'Status', 'Notes']);

            foreach ($appointments as $a) {
                fputcsv($out, [
                    $a->id,
                    $a->user->name,
                    $a->user->email,
                    $a->user->phone,
                    $a->service->name,
                    $a->appointment_date->format('Y-m-d'),
                    $a->appointment_time,
                    $a->status,
                    $a->notes,
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Base query honouring the status/date filters shared by index + export.
     */
    private function filtered(Request $request)
    {
        $status = $request->query('status');
        $date = $request->query('date');

        return Appointment::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($date, fn ($q) => $q->whereDate('appointment_date', $date));
    }
}
