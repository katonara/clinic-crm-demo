<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clinic services (mirror the landing page service cards).
        $services = [
            ['name' => 'General Consultation', 'icon' => 'stethoscope', 'description' => 'Speak with a qualified doctor about everyday health concerns and get expert guidance.'],
            ['name' => 'Aesthetic Treatment', 'icon' => 'sparkles', 'description' => 'Personalised aesthetic procedures designed to help you look and feel your best.'],
            ['name' => 'Skin Treatment', 'icon' => 'face', 'description' => 'Targeted care for acne, pigmentation and other common skin conditions.'],
            ['name' => 'Weight Management', 'icon' => 'scale', 'description' => 'Structured, medically supervised programmes to reach your healthy weight goals.'],
            ['name' => 'Laser Treatment', 'icon' => 'laser', 'description' => 'Advanced laser therapies for hair removal, skin renewal and more.'],
            ['name' => 'Follow-up Appointment', 'icon' => 'refresh', 'description' => 'Easy re-booking to track your progress and continue your treatment plan.'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($service['name'])],
                $service + ['slug' => \Illuminate\Support\Str::slug($service['name']), 'is_active' => true],
            );
        }

        // Treatment rooms — capacity per time slot equals the number of active rooms.
        for ($i = 1; $i <= 5; $i++) {
            Room::updateOrCreate(['name' => "Treatment Room {$i}"], ['is_active' => true]);
        }

        // Clinic staff / admin account.
        User::updateOrCreate(
            ['email' => 'staff@cliniccare.example'],
            [
                'name' => 'Clinic Staff',
                'role' => 'staff',
                'phone' => '+60 12-345 6789',
                'whatsapp' => '+60 12-345 6789',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        // Demo patient account (pre-verified for convenience).
        User::updateOrCreate(
            ['email' => 'patient@cliniccare.example'],
            [
                'name' => 'Demo Patient',
                'role' => 'patient',
                'phone' => '+60 11-111 1111',
                'whatsapp' => '+60 11-111 1111',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
    }
}
