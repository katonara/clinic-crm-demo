<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $date = $request->query('date');

        $appointments = Appointment::with(['user', 'service'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($date, fn ($q) => $q->whereDate('appointment_date', $date))
            ->orderByDesc('appointment_date')
            ->orderBy('appointment_time')
            ->paginate(15)
            ->withQueryString();

        return view('admin.appointments', [
            'appointments' => $appointments,
            'statuses' => Appointment::STATUSES,
            'currentStatus' => $status,
            'currentDate' => $date,
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', Appointment::STATUSES)],
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('status', "Appointment #{$appointment->id} marked as {$validated['status']}.");
    }
}
