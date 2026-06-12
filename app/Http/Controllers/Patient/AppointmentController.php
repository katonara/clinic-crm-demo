<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Time slots offered by the clinic.
     */
    public const TIME_SLOTS = [
        '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
        '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
    ];

    public function create(Request $request): View
    {
        $services = Service::where('is_active', true)->orderBy('name')->get();

        return view('patient.book', [
            'services' => $services,
            'slots' => self::TIME_SLOTS,
            'selectedService' => $request->query('service'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'in:' . implode(',', self::TIME_SLOTS)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->appointments()->create($validated + ['status' => 'pending']);

        return redirect()->route('patient.dashboard')
            ->with('status', 'Your appointment request has been submitted. Our staff will confirm it shortly.');
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        if (in_array($appointment->status, ['pending', 'confirmed'], true)) {
            $appointment->update(['status' => 'cancelled']);
        }

        return back()->with('status', 'Appointment cancelled.');
    }
}
