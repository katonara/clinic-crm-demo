<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    private function makeService(): Service
    {
        return Service::create([
            'name' => 'General Consultation',
            'slug' => 'general-consultation',
            'icon' => 'stethoscope',
            'description' => 'Test service',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_from_protected_pages(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
    }

    public function test_patient_can_register_verify_and_book(): void
    {
        // Register
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+60 12-000 0000',
            'whatsapp' => '+60 12-000 0000',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('verification.notice'));
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com', 'role' => 'patient']);

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertNull($user->email_verified_at);
        $this->assertNotNull($user->email_otp);

        // Verify OTP
        $this->actingAs($user)
            ->post('/verify-email', ['code' => $user->email_otp])
            ->assertRedirect(route('patient.dashboard'));

        $this->assertNotNull($user->fresh()->email_verified_at);

        // Book an appointment
        $service = $this->makeService();

        $this->actingAs($user->fresh())->post('/book-appointment', [
            'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '09:00',
            'notes' => 'First visit',
        ])->assertRedirect(route('patient.dashboard'));

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);
    }

    public function test_wrong_otp_is_rejected(): void
    {
        $user = User::create([
            'name' => 'Bob', 'email' => 'bob@example.com', 'phone' => '1',
            'role' => 'patient', 'password' => Hash::make('password123'),
            'email_otp' => '123456', 'email_otp_expires_at' => now()->addMinutes(10),
        ]);

        $this->actingAs($user)->post('/verify-email', ['code' => '000000'])
            ->assertSessionHasErrors('code');

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_staff_can_confirm_and_patient_cannot_access_admin(): void
    {
        $staff = User::create([
            'name' => 'Staff', 'email' => 'staff@example.com', 'phone' => '1',
            'role' => 'staff', 'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $patient = User::create([
            'name' => 'Pat', 'email' => 'pat@example.com', 'phone' => '1',
            'role' => 'patient', 'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $service = $this->makeService();
        $appointment = Appointment::create([
            'user_id' => $patient->id,
            'service_id' => $service->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:00',
            'status' => 'pending',
        ]);

        // Staff confirms
        $this->actingAs($staff)
            ->patch(route('admin.appointments.status', $appointment), ['status' => 'confirmed'])
            ->assertRedirect();
        $this->assertEquals('confirmed', $appointment->fresh()->status);

        // Patient is forbidden from admin
        $this->actingAs($patient)->get('/admin/dashboard')->assertForbidden();
    }
}
