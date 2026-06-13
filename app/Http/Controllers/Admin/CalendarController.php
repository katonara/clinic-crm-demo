<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
    public function index(Request $request): View
    {
        // Resolve the month being viewed (defaults to current month).
        $monthParam = $request->query('month');
        try {
            $cursor = $monthParam
                ? CarbonImmutable::createFromFormat('Y-m', $monthParam)->startOfMonth()
                : CarbonImmutable::now()->startOfMonth();
        } catch (\Throwable) {
            $cursor = CarbonImmutable::now()->startOfMonth();
        }

        $start = $cursor->startOfMonth();
        $end = $cursor->endOfMonth();

        // Appointment counts grouped by day for this month (non-cancelled).
        $counts = Appointment::query()
            ->whereBetween('appointment_date', [$start->toDateString(), $end->toDateString()])
            ->where('status', '!=', 'cancelled')
            ->get()
            ->groupBy(fn ($a) => $a->appointment_date->toDateString())
            ->map->count();

        // Build the calendar grid (weeks starting Monday).
        $gridStart = $start->startOfWeek(CarbonImmutable::MONDAY);
        $gridEnd = $end->endOfWeek(CarbonImmutable::MONDAY);

        $weeks = [];
        $day = $gridStart;
        while ($day <= $gridEnd) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'date' => $day,
                    'inMonth' => $day->month === $cursor->month,
                    'count' => $counts->get($day->toDateString(), 0),
                    'isToday' => $day->isToday(),
                ];
                $day = $day->addDay();
            }
            $weeks[] = $week;
        }

        return view('admin.calendar', [
            'cursor' => $cursor,
            'weeks' => $weeks,
            'prevMonth' => $cursor->subMonth()->format('Y-m'),
            'nextMonth' => $cursor->addMonth()->format('Y-m'),
        ]);
    }
}
