<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        // Status breakdown.
        $byStatus = Appointment::selectRaw('status, COUNT(*) as c')
            ->groupBy('status')->pluck('c', 'status');

        $statusCounts = [];
        foreach (Appointment::STATUSES as $status) {
            $statusCounts[$status] = (int) ($byStatus[$status] ?? 0);
        }

        // Last 6 months (including current), non-cancelled.
        $months = [];
        $cursor = CarbonImmutable::now()->startOfMonth()->subMonths(5);
        for ($i = 0; $i < 6; $i++) {
            $m = $cursor->addMonths($i);
            $count = Appointment::whereYear('appointment_date', $m->year)
                ->whereMonth('appointment_date', $m->month)
                ->where('status', '!=', 'cancelled')
                ->count();
            $months[] = ['label' => $m->format('M Y'), 'count' => $count];
        }

        // By service.
        $byService = Appointment::with('service')
            ->where('status', '!=', 'cancelled')
            ->get()
            ->groupBy(fn ($a) => $a->service->name ?? '—')
            ->map->count()
            ->sortDesc();

        // By room (utilisation).
        $byRoom = Appointment::with('room')
            ->where('status', '!=', 'cancelled')
            ->get()
            ->groupBy(fn ($a) => $a->room->name ?? 'Unassigned')
            ->map->count()
            ->sortDesc();

        return view('admin.reports', [
            'total' => Appointment::count(),
            'statusCounts' => $statusCounts,
            'months' => $months,
            'byService' => $byService,
            'byRoom' => $byRoom,
        ]);
    }
}
