@extends('layouts.dashboard')

@section('title', 'Staff Dashboard')

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Staff Dashboard</h1>
    <p class="mt-1 text-sm text-slate-500">Overview for {{ now()->format('l, d M Y') }}.</p>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-5">
        @foreach ([
            ['label' => "Today's bookings", 'value' => $stats['today'], 'color' => 'text-slate-900'],
            ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'text-amber-600'],
            ['label' => 'Confirmed', 'value' => $stats['confirmed'], 'color' => 'text-green-600'],
            ['label' => 'Patients', 'value' => $stats['patients'], 'color' => 'text-brand-700'],
            ['label' => 'Active services', 'value' => $stats['services'], 'color' => 'text-slate-900'],
        ] as $stat)
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-xs text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-1 text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Today's list --}}
    <div class="mt-8 rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">Today's Appointments</h2>
            <a href="{{ route('admin.appointments') }}" class="text-sm font-semibold text-brand-700 hover:underline">View all →</a>
        </div>

        @forelse ($todays as $appointment)
            <div class="flex flex-col gap-3 border-b border-slate-50 px-6 py-4 last:border-0 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <span class="w-14 shrink-0 rounded-lg bg-brand-50 py-1.5 text-center text-sm font-bold text-brand-700">{{ $appointment->appointment_time }}</span>
                    <div>
                        <p class="font-semibold text-slate-900">{{ $appointment->user->name }}</p>
                        <p class="text-sm text-slate-500">{{ $appointment->service->name }} · {{ $appointment->user->phone }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $appointment->statusBadgeClass() }}">{{ $appointment->status }}</span>
                    @if ($url = $appointment->user->whatsappUrl('Hi ' . $appointment->user->name . ', regarding your appointment today at ' . $appointment->appointment_time . '.'))
                        <a href="{{ $url }}" target="_blank" rel="noopener" title="Message on WhatsApp"
                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 text-green-600 transition hover:bg-green-100">
                            <x-icon name="chat" class="h-4 w-4" />
                        </a>
                    @endif
                    @include('admin.partials.status-actions', ['appointment' => $appointment])
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center text-sm text-slate-500">No appointments scheduled for today.</div>
        @endforelse
    </div>
@endsection
