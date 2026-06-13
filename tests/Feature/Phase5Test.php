<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Mail\AppointmentMail;
use Tests\TestCase;

class Phase5Test extends TestCase
{
    use RefreshDatabase;

    private function service(): Service
    {
        return Service::create([
            'name' => 'General Consultation', 'slug' => 'general-consultation',
            'icon' => 'stethoscope', 'description' => 'Test', 'is_active' => true,
        ]);
    }

    private function patient(array $attrs = []): User
    {
        return User::create(array_merge([
            'name' => 'Pat', 'email' => 'pat@example.com', 'phone' => '+60 12-345 6789',
            'whatsapp' => '+60 12-345 6789', 'role' => 'patient',
            'password' => Hash::make('password123'), 'email_verified_at' => now(),
        ], $attrs));
    }

    private function staff(): User
    {
        return User::create([
            'name' => 'Staff', 'email' => 'staff@example.com', 'phone' => '1',
            'role' => 'staff', 'password' => Hash::make('password123'), 'email_verified_at' => now(),
        ]);
    }

    public function test_double_booking_is_blocked_and_mail_sent(): void
    {
        Mail::fake();
        $patient = $this->patient();
        $other = $this->patient(['email' => 'other@example.com']);
        $service = $this->service();
        $date = now()->addDay()->toDateString();

        $this->actingAs($patient)->post('/book-appointment', [
            'service_id' => $service->id, 'appointment_date' => $date, 'appointment_time' => '09:00',
        ])->assertRedirect(route('patient.dashboard'));

        Mail::assertSent(AppointmentMail::class);

        // Same slot, different patient -> rejected.
        $this->actingAs($other)->post('/book-appointment', [
            'service_id' => $service->id, 'appointment_date' => $date, 'appointment_time' => '09:00',
        ])->assertSessionHasErrors('appointment_time');

        $this->assertEquals(1, Appointment::count());
    }

    public function test_availability_endpoint_reports_taken_slots(): void
    {
        $patient = $this->patient();
        $service = $this->service();
        $date = now()->addDay()->toDateString();

        Appointment::create([
            'user_id' => $patient->id, 'service_id' => $service->id,
            'appointment_date' => $date, 'appointment_time' => '10:00', 'status' => 'pending',
        ]);

        $this->actingAs($patient)
            ->getJson('/book-appointment/availability?date=' . $date)
            ->assertOk()
            ->assertJsonFragment(['taken' => ['10:00']]);
    }

    public function test_patient_can_reschedule(): void
    {
        $patient = $this->patient();
        $service = $this->service();
        $appt = Appointment::create([
            'user_id' => $patient->id, 'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(), 'appointment_time' => '09:00', 'status' => 'confirmed',
        ]);

        $newDate = now()->addDays(2)->toDateString();
        $this->actingAs($patient)->patch("/appointments/{$appt->id}", [
            'appointment_date' => $newDate, 'appointment_time' => '11:00',
        ])->assertRedirect(route('patient.dashboard'));

        $this->assertDatabaseHas('appointments', [
            'id' => $appt->id, 'appointment_time' => '11:00',
        ]);
    }

    public function test_password_reset_flow_updates_hash(): void
    {
        Notification::fake();
        $patient = $this->patient();

        $this->post('/forgot-password', ['email' => $patient->email])->assertSessionHas('status');

        Notification::assertSentTo($patient, ResetPassword::class, function ($notification) use ($patient) {
            $token = $notification->token;

            $this->post('/reset-password', [
                'token' => $token, 'email' => $patient->email,
                'password' => 'newpassword123', 'password_confirmation' => 'newpassword123',
            ])->assertRedirect(route('login'));

            return true;
        });

        $this->assertTrue(Hash::check('newpassword123', $patient->fresh()->password));
    }

    public function test_profile_password_change(): void
    {
        $patient = $this->patient();

        $this->actingAs($patient)->patch('/profile/password', [
            'current_password' => 'password123',
            'password' => 'changed12345', 'password_confirmation' => 'changed12345',
        ])->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('changed12345', $patient->fresh()->password));
    }

    public function test_admin_csv_export_and_pages_load(): void
    {
        $staff = $this->staff();
        $patient = $this->patient();
        $service = $this->service();
        Appointment::create([
            'user_id' => $patient->id, 'service_id' => $service->id,
            'appointment_date' => now()->toDateString(), 'appointment_time' => '09:00', 'status' => 'pending',
        ]);

        $this->actingAs($staff)->get('/admin/patients')->assertOk()->assertSee('Pat');
        $this->actingAs($staff)->get(route('admin.patients.show', $patient))->assertOk();
        $this->actingAs($staff)->get('/admin/calendar')->assertOk();

        $res = $this->actingAs($staff)->get('/admin/appointments/export');
        $res->assertOk();
        $this->assertStringContainsString('text/csv', $res->headers->get('content-type'));
    }

    public function test_reminder_command_runs(): void
    {
        Mail::fake();
        $patient = $this->patient();
        $service = $this->service();
        Appointment::create([
            'user_id' => $patient->id, 'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(), 'appointment_time' => '09:00', 'status' => 'confirmed',
        ]);

        $this->artisan('appointments:reminders')->assertExitCode(0);
        Mail::assertSent(AppointmentMail::class);
    }
}
