<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->toDateString();

        $todays = Appointment::with(['user', 'service'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();

        $stats = [
            'today' => $todays->count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'patients' => User::where('role', 'patient')->count(),
            'services' => Service::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('todays', 'stats'));
    }
}
