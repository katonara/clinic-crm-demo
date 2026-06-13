<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $patients = User::where('role', 'patient')
            ->withCount('appointments')
            ->when($search, fn ($query) => $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.patients.index', [
            'patients' => $patients,
            'search' => $search,
        ]);
    }

    public function show(User $patient): View
    {
        abort_unless($patient->role === 'patient', 404);

        $appointments = $patient->appointments()
            ->with('service')
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        return view('admin.patients.show', [
            'patient' => $patient,
            'appointments' => $appointments,
        ]);
    }
}
