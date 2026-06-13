<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  Appointment  $appointment
     * @param  string  $kind  booked|confirmed|completed|cancelled|reminder
     */
    public function __construct(
        public Appointment $appointment,
        public string $kind,
    ) {}

    public function envelope(): Envelope
    {
        $subjects = [
            'booked' => 'We received your appointment request',
            'confirmed' => 'Your appointment is confirmed',
            'completed' => 'Thank you for visiting ClinicCare',
            'cancelled' => 'Your appointment was cancelled',
            'reminder' => 'Reminder: your appointment tomorrow',
        ];

        return new Envelope(
            subject: $subjects[$this->kind] ?? 'ClinicCare appointment update',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.appointment');
    }
}
