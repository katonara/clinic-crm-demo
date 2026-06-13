<?php

namespace Tests\Feature;

use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
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

    private function rooms(int $n = 5): void
    {
        for ($i = 1; $i <= $n; $i++) {
            Room::create(['name' => "Room {$i}", 'is_active' => true]);
        }
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

    private function book(User $user, Service $service, string $date, string $time)
    {
        return $this->actingAs($user)->post('/book-appointment', [
            'service_id' => $service->id, 'appointment_date' => $date, 'appointment_time' => $time,
        ]);
    }

    public function test_capacity_allows_multiple_bookings_until_full(): void
    {
        Mail::fake();
        $service = $this->service();
        $this->rooms(2); // capacity 2 per slot
        $date = now()->addDay()->toDateString();

        $this->book($this->patient(['email' => 'a@example.com']), $service, $date, '10:00')
            ->assertRedirect(route('patient.dashboard'));
        $this->book($this->patient(['email' => 'b@example.com']), $service, $date, '10:00')
            ->assertRedirect(route('patient.dashboard'));

        // Third booking at the same slot is rejected (both rooms taken).
        $this->book($this->patient(['email' => 'c@example.com']), $service, $date, '10:00')
            ->assertSessionHasErrors('appointment_time');

        $this->assertEquals(2, Appointment::where('appointment_time', '10:00')->count());
        Mail::assertSent(AppointmentMail::class);
    }

    public function test_each_booking_is_assigned_a_distinct_room(): void
    {
        $service = $this->service();
        $this->rooms(3);
        $date = now()->addDay()->toDateString();

        $this->book($this->patient(['email' => 'a@example.com']), $service, $date, '11:00');
        $this->book($this->patient(['email' => 'b@example.com']), $service, $date, '11:00');

        $roomIds = Appointment::where('appointment_time', '11:00')->pluck('room_id');
        $this->assertCount(2, $roomIds->unique()); // distinct rooms
        $this->assertTrue($roomIds->every(fn ($id) => $id !== null));
    }

    public function test_availability_reports_full_slots_only(): void
    {
        $service = $this->service();
        $this->rooms(1); // capacity 1 -> one booking fills the slot
        $patient = $this->patient();
        $date = now()->addDay()->toDateString();

        $this->book($patient, $service, $date, '10:00');

        $this->actingAs($patient)
            ->getJson('/book-appointment/availability?date=' . $date)
            ->assertOk()
            ->assertJsonFragment(['full' => ['10:00']]);
    }

    public function test_patient_can_reschedule(): void
    {
        $service = $this->service();
        $this->rooms();
        $patient = $this->patient();
        $appt = Appointment::create([
            'user_id' => $patient->id, 'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(), 'appointment_time' => '10:00', 'status' => 'confirmed',
        ]);

        $this->actingAs($patient)->patch("/appointments/{$appt->id}", [
            'appointment_date' => now()->addDays(2)->toDateString(), 'appointment_time' => '11:00',
        ])->assertRedirect(route('patient.dashboard'));

        $this->assertDatabaseHas('appointments', ['id' => $appt->id, 'appointment_time' => '11:00']);
        $this->assertNotNull($appt->fresh()->room_id);
    }

    public function test_staff_can_reschedule(): void
    {
        $service = $this->service();
        $this->rooms();
        $appt = Appointment::create([
            'user_id' => $this->patient()->id, 'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(), 'appointment_time' => '10:00', 'status' => 'pending',
        ]);

        $this->actingAs($this->staff())->patch(route('admin.appointments.update', $appt), [
            'appointment_date' => now()->addDays(3)->toDateString(), 'appointment_time' => '14:00',
        ])->assertRedirect(route('admin.appointments'));

        $this->assertDatabaseHas('appointments', ['id' => $appt->id, 'appointment_time' => '14:00']);
    }

    public function test_password_reset_flow_updates_hash(): void
    {
        Notification::fake();
        $patient = $this->patient();

        $this->post('/forgot-password', ['email' => $patient->email])->assertSessionHas('status');

        Notification::assertSentTo($patient, ResetPassword::class, function ($notification) use ($patient) {
            $this->post('/reset-password', [
                'token' => $notification->token, 'email' => $patient->email,
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

    public function test_admin_pages_load_and_csv_export(): void
    {
        $staff = $this->staff();
        $patient = $this->patient();
        $service = $this->service();
        $this->rooms();
        Appointment::create([
            'user_id' => $patient->id, 'service_id' => $service->id, 'room_id' => Room::first()->id,
            'appointment_date' => now()->toDateString(), 'appointment_time' => '10:00', 'status' => 'pending',
        ]);

        $this->actingAs($staff)->get('/admin/patients')->assertOk()->assertSee('Pat');
        $this->actingAs($staff)->get(route('admin.patients.show', $patient))->assertOk();
        $this->actingAs($staff)->get('/admin/calendar')->assertOk();
        $this->actingAs($staff)->get('/admin/reports')->assertOk();
        $this->actingAs($staff)->get('/admin/rooms')->assertOk()->assertSee('Room 1');

        $res = $this->actingAs($staff)->get('/admin/appointments/export');
        $res->assertOk();
        $this->assertStringContainsString('text/csv', $res->headers->get('content-type'));
    }

    public function test_admin_can_add_and_toggle_room(): void
    {
        $staff = $this->staff();

        $this->actingAs($staff)->post('/admin/rooms', ['name' => 'Room X'])->assertRedirect();
        $this->assertDatabaseHas('rooms', ['name' => 'Room X', 'is_active' => true]);

        $room = Room::where('name', 'Room X')->first();
        $this->actingAs($staff)->patch(route('admin.rooms.toggle', $room))->assertRedirect();
        $this->assertFalse($room->fresh()->is_active);
    }

    public function test_reminder_command_runs(): void
    {
        Mail::fake();
        $service = $this->service();
        $this->rooms();
        Appointment::create([
            'user_id' => $this->patient()->id, 'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(), 'appointment_time' => '10:00', 'status' => 'confirmed',
        ]);

        $this->artisan('appointments:reminders')->assertExitCode(0);
        Mail::assertSent(AppointmentMail::class);
    }
}
