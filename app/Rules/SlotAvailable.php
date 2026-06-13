<?php

namespace App\Rules;

use App\Models\Appointment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Ensures a date + time slot is not already taken by a non-cancelled appointment.
 * Assumes a single-room clinic: one active appointment per slot.
 */
class SlotAvailable implements ValidationRule
{
    public function __construct(
        private ?string $date,
        private ?int $ignoreAppointmentId = null,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (blank($this->date) || blank($value)) {
            return; // other rules handle required/format
        }

        $taken = Appointment::query()
            ->whereDate('appointment_date', $this->date)
            ->where('appointment_time', $value)
            ->where('status', '!=', 'cancelled')
            ->when($this->ignoreAppointmentId, fn ($q) => $q->where('id', '!=', $this->ignoreAppointmentId))
            ->exists();

        if ($taken) {
            $fail('That time slot is already booked. Please choose another time.');
        }
    }
}
