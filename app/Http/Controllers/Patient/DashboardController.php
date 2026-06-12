<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $appointments = $user->appointments()
            ->with('service')
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        $stats = [
            'total' => $appointments->count(),
            'upcoming' => $appointments->whereIn('status', ['pending', 'confirmed'])
                ->where('appointment_date', '>=', now()->startOfDay())->count(),
            'pending' => $appointments->where('status', 'pending')->count(),
            'completed' => $appointments->where('status', 'completed')->count(),
        ];

        return view('patient.dashboard', compact('appointments', 'stats'));
    }
}
