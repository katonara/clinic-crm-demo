<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Service;
use App\Services\RoomScheduler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function __construct(private RoomScheduler $scheduler) {}

    public function create(Request $request): View
    {
        return view('patient.book', [
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
            'slots' => RoomScheduler::SLOTS,
            'selectedService' => $request->query('service'),
            'appointment' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'in:' . implode(',', RoomScheduler::SLOTS)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $roomId = $this->assignRoomOrFail($validated['appointment_date'], $validated['appointment_time']);

        $appointment = Auth::user()->appointments()->create($validated + [
            'room_id' => $roomId,
            'status' => 'pending',
        ]);

        $this->notify($appointment, 'booked');

        return redirect()->route('patient.dashboard')
            ->with('status', 'Your appointment request has been submitted. Our staff will confirm it shortly.');
    }

    public function edit(Appointment $appointment): View
    {
        abort_unless($appointment->user_id === Auth::id(), 403);
        abort_unless(in_array($appointment->status, ['pending', 'confirmed'], true), 403);

        $appointment->load('service');

        return view('patient.book', [
            'services' => Service::where('is_active', true)->orderBy('name')->get(),
            'slots' => RoomScheduler::SLOTS,
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
            'appointment_time' => ['required', 'in:' . implode(',', RoomScheduler::SLOTS)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $roomId = $this->assignRoomOrFail($validated['appointment_date'], $validated['appointment_time'], $appointment->id);

        $appointment->update($validated + ['room_id' => $roomId]);

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
     * JSON list of fully-booked time slots for a date (used to grey out the picker).
     */
    public function availability(Request $request): JsonResponse
    {
        return response()->json([
            'full' => $this->scheduler->fullSlots(
                (string) $request->query('date'),
                $request->query('ignore') ? (int) $request->query('ignore') : null,
            ),
        ]);
    }

    /**
     * Resolve a free room for the slot or throw a validation error when full.
     */
    private function assignRoomOrFail(string $date, string $time, ?int $ignoreId = null): int
    {
        $roomId = $this->scheduler->freeRoomId($date, $time, $ignoreId);

        if ($roomId === null) {
            throw ValidationException::withMessages([
                'appointment_time' => 'That time slot is fully booked. Please choose another time.',
            ]);
        }

        return $roomId;
    }

    private function notify(Appointment $appointment, string $kind): void
    {
        $appointment->loadMissing(['user', 'service']);
        Mail::to($appointment->user->email)->send(new AppointmentMail($appointment, $kind));
    }
}
