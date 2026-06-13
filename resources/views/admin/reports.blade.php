@extends('layouts.dashboard')

@section('title', 'Reports')

@php
    $monthMax = max(1, collect($months)->max('count'));
    $serviceMax = max(1, $byService->max() ?? 0);
    $roomMax = max(1, $byRoom->max() ?? 0);
    $statusColors = [
        'pending' => 'bg-amber-500', 'confirmed' => 'bg-green-500',
        'completed' => 'bg-brand-600', 'cancelled' => 'bg-rose-500',
    ];
@endphp

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Reports</h1>
    <p class="mt-1 text-sm text-slate-500">Booking insights across your clinic.</p>

    {{-- Summary cards --}}
    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <p class="text-xs text-slate-500">Total appointments</p>
            <p class="mt-1 text-3xl font-bold text-slate-900">{{ $total }}</p>
        </div>
        @foreach ($statusCounts as $status => $count)
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-xs capitalize text-slate-500">{{ $status }}</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">{{ $count }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        {{-- Monthly trend --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">Bookings — last 6 months</h2>
            <div class="mt-6 flex h-48 items-end gap-3">
                @foreach ($months as $m)
                    <div class="flex flex-1 flex-col items-center gap-2">
                        <span class="text-xs font-semibold text-slate-600">{{ $m['count'] }}</span>
                        <div class="flex w-full items-end" style="height: 140px;">
                            <div class="w-full rounded-t-lg bg-brand-500 transition-all"
                                style="height: {{ max(4, (int) round($m['count'] / $monthMax * 140)) }}px;"></div>
                        </div>
                        <span class="text-[11px] text-slate-400">{{ $m['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Status distribution --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">Status distribution</h2>
            <div class="mt-6 space-y-4">
                @foreach ($statusCounts as $status => $count)
                    <div>
                        <div class="mb-1 flex justify-between text-xs">
                            <span class="capitalize text-slate-600">{{ $status }}</span>
                            <span class="font-semibold text-slate-700">{{ $count }}</span>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full {{ $statusColors[$status] ?? 'bg-slate-400' }}"
                                style="width: {{ $total > 0 ? round($count / $total * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- By service --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">Bookings by service</h2>
            <div class="mt-6 space-y-3">
                @forelse ($byService as $name => $count)
                    <div>
                        <div class="mb-1 flex justify-between text-xs">
                            <span class="text-slate-600">{{ $name }}</span>
                            <span class="font-semibold text-slate-700">{{ $count }}</span>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-brand-500" style="width: {{ round($count / $serviceMax * 100) }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No data yet.</p>
                @endforelse
            </div>
        </div>

        {{-- By room --}}
        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-slate-900">Room utilisation</h2>
            <div class="mt-6 space-y-3">
                @forelse ($byRoom as $name => $count)
                    <div>
                        <div class="mb-1 flex justify-between text-xs">
                            <span class="text-slate-600">{{ $name }}</span>
                            <span class="font-semibold text-slate-700">{{ $count }}</span>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-100">
                            <div class="h-full rounded-full bg-green-500" style="width: {{ round($count / $roomMax * 100) }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No data yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
