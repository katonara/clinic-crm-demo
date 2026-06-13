@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Hi, {{ auth()->user()->name }} 👋</h1>
            <p class="mt-1 text-sm text-slate-500">Here's an overview of your appointments.</p>
        </div>
        <a href="{{ route('book') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/></svg>
            Book Appointment
        </a>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ([
            ['label' => 'Total', 'value' => $stats['total'], 'color' => 'text-slate-900'],
            ['label' => 'Upcoming', 'value' => $stats['upcoming'], 'color' => 'text-brand-700'],
            ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'text-amber-600'],
            ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'text-green-600'],
        ] as $stat)
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-1 text-3xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Appointments --}}
    <div class="mt-8 rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-slate-900">My Appointments</h2>
        </div>

        @forelse ($appointments as $appointment)
            <div class="flex flex-col gap-3 border-b border-slate-50 px-6 py-4 last:border-0 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex w-14 shrink-0 flex-col items-center rounded-xl bg-brand-50 py-2 text-center">
                        <span class="text-xs font-semibold uppercase text-brand-600">{{ $appointment->appointment_date->format('M') }}</span>
                        <span class="text-lg font-bold text-brand-700">{{ $appointment->appointment_date->format('d') }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900">{{ $appointment->service->name }}</p>
                        <p class="text-sm text-slate-500">
                            {{ $appointment->appointment_date->format('D, d M Y') }} at {{ $appointment->appointment_time }}
                        </p>
                        @if ($appointment->notes)
                            <p class="mt-1 text-xs text-slate-400">Note: {{ $appointment->notes }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $appointment->statusBadgeClass() }}">
                        {{ $appointment->status }}
                    </span>
                    @if (in_array($appointment->status, ['pending', 'confirmed']))
                        <a href="{{ route('patient.appointments.edit', $appointment) }}" class="text-xs font-semibold text-brand-700 hover:underline">Reschedule</a>
                        <form method="POST" action="{{ route('patient.appointments.cancel', $appointment) }}"
                            onsubmit="return confirm('Cancel this appointment?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-semibold text-rose-600 hover:underline">Cancel</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center">
                <p class="text-sm text-slate-500">You have no appointments yet.</p>
                <a href="{{ route('book') }}" class="mt-3 inline-block text-sm font-semibold text-brand-700 hover:underline">Book your first appointment →</a>
            </div>
        @endforelse
    </div>
@endsection
