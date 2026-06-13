<?php

namespace App\Console\Commands;

use App\Mail\AppointmentMail;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:reminders';

    protected $description = 'Email reminders to patients with a confirmed appointment tomorrow.';

    public function handle(): int
    {
        $tomorrow = now()->addDay()->toDateString();

        $appointments = Appointment::with(['user', 'service'])
            ->whereDate('appointment_date', $tomorrow)
            ->where('status', 'confirmed')
            ->get();

        foreach ($appointments as $appointment) {
            Mail::to($appointment->user->email)->send(new AppointmentMail($appointment, 'reminder'));
        }

        $this->info("Sent {$appointments->count()} reminder(s) for {$tomorrow}.");

        return self::SUCCESS;
    }
}
