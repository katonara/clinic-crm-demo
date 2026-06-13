<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Service;
use App\Rules\SlotAvailable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            'appointment' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'in:' . implode(',', self::TIME_SLOTS), new SlotAvailable($request->input('appointment_date'))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $appointment = Auth::user()->appointments()->create($validated + ['status' => 'pending']);

        $this->notify($appointment, 'booked');

        return redirect()->route('patient.dashboard')
            ->with('status', 'Your appointment request has been submitted. Our staff will confirm it shortly.');
    }

    /**
     * Show the reschedule form (booking form in edit mode; service is locked).
     */
    public function edit(Appointment $appointment): View
    {
        abort_unless($appointment->user_id === Auth::id(), 403);
        abort_unless(in_array($appointment->status, ['pending', 'confirmed'], true), 403);

        $appointment->load('service');

        return view('patient.book', [
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
            'slots' => self::TIME_SLOTS,
            'selectedService' => $appointment->service_id,
            'appointment' => $appointment,
        ]);
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        abort_unless($appointment->user_id === Auth::id(), 403);
        abort_unless(in_array($appointment->status, ['pending', 'confirmed'], true), 403);

        $validated = $request->validate([
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'in:' . implode(',', self::TIME_SLOTS), new SlotAvailable($request->input('appointment_date'), $appointment->id)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $appointment->update($validated);

        return redirect()->route('patient.dashboard')
            ->with('status', 'Your appointment has been rescheduled.');
    }

    public function cancel(Appointment $appointment): RedirectResponse
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        if (in_array($appointment->status, ['pending', 'confirmed'], true)) {
            $appointment->update(['status' => 'cancelled']);
            $this->notify($appointment, 'cancelled');
        }

        return back()->with('status', 'Appointment cancelled.');
    }

    /**
     * JSON list of taken time slots for a given date (used to grey out the dropdown).
     */
    public function availability(Request $request): JsonResponse
    {
        $date = $request->query('date');
        $ignore = $request->query('ignore');

        $taken = Appointment::query()
            ->when($date, fn ($q) => $q->whereDate('appointment_date', $date))
            ->where('status', '!=', 'cancelled')
            ->when($ignore, fn ($q) => $q->where('id', '!=', $ignore))
            ->pluck('appointment_time')
            ->unique()
            ->values();

        // For today, also block times that have already passed.
        $past = [];
        if ($date === now()->toDateString()) {
            $now = now()->format('H:i');
            $past = array_values(array_filter(self::TIME_SLOTS, fn ($s) => $s <= $now));
        }

        return response()->json([
            'taken' => $taken->merge($past)->unique()->values(),
        ]);
    }

    private function notify(Appointment $appointment, string $kind): void
    {
        $appointment->loadMissing(['user', 'service']);
        Mail::to($appointment->user->email)->send(new AppointmentMail($appointment, $kind));
    }
}
