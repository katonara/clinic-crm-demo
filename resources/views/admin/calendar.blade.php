@extends('layouts.dashboard')

@section('title', 'Calendar')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Appointment Calendar</h1>
            <p class="mt-1 text-sm text-slate-500">Booking volume per day (cancelled excluded).</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.calendar', ['month' => $prevMonth]) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">&larr;</a>
            <span class="min-w-40 text-center text-sm font-semibold text-slate-900">{{ $cursor->format('F Y') }}</span>
            <a href="{{ route('admin.calendar', ['month' => $nextMonth]) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">&rarr;</a>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">
            @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dow)
                <div class="px-2 py-3">{{ $dow }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7">
            @foreach ($weeks as $week)
                @foreach ($week as $day)
                    <div @class([
                        'min-h-24 border-b border-r border-slate-50 p-2',
                        'bg-white' => $day['inMonth'],
                        'bg-slate-50/50 text-slate-300' => ! $day['inMonth'],
                    ])>
                        <div class="flex items-center justify-between">
                            <span @class([
                                'inline-flex h-6 w-6 items-center justify-center rounded-full text-xs font-semibold',
                                'bg-brand-600 text-white' => $day['isToday'],
                                'text-slate-700' => ! $day['isToday'] && $day['inMonth'],
                            ])>{{ $day['date']->format('j') }}</span>
                        </div>

                        @if ($day['inMonth'] && $day['count'] > 0)
                            <a href="{{ route('admin.appointments', ['date' => $day['date']->toDateString()]) }}"
                                class="mt-2 block rounded-lg bg-brand-50 px-2 py-1 text-center text-xs font-semibold text-brand-700 transition hover:bg-brand-100">
                                {{ $day['count'] }} {{ \Illuminate\Support\Str::plural('booking', $day['count']) }}
                            </a>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
