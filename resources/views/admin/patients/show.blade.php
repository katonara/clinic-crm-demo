@extends('layouts.dashboard')

@section('title', $patient->name)

@section('content')
    <a href="{{ route('admin.patients') }}" class="text-sm font-semibold text-brand-700 hover:underline">&larr; Back to patients</a>

    <div class="mt-4 grid gap-6 lg:grid-cols-3">
        {{-- Profile card --}}
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-xl font-bold text-brand-700">
                    {{ \Illuminate\Support\Str::of($patient->name)->substr(0, 1)->upper() }}
                </div>
                <h1 class="mt-4 text-xl font-bold text-slate-900">{{ $patient->name }}</h1>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-slate-400">Email</dt>
                        <dd class="text-slate-700">{{ $patient->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-400">Phone</dt>
                        <dd class="text-slate-700">{{ $patient->phone ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-400">WhatsApp</dt>
                        <dd class="text-slate-700">{{ $patient->whatsapp ?: '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-400">Joined</dt>
                        <dd class="text-slate-700">{{ $patient->created_at->format('d M Y') }}</dd>
                    </div>
                </dl>

                @if ($url = $patient->whatsappUrl('Hi ' . $patient->name . ', this is ClinicCare regarding your appointment.'))
                    <a href="{{ $url }}" target="_blank" rel="noopener"
                        class="mt-5 flex items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700">
                        <x-icon name="chat" class="h-4 w-4" /> Message on WhatsApp
                    </a>
                @endif
            </div>
        </div>

        {{-- History --}}
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-slate-100 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-lg font-semibold text-slate-900">Appointment History ({{ $appointments->count() }})</h2>
                </div>
                @forelse ($appointments as $appointment)
                    <div class="flex items-center justify-between border-b border-slate-50 px-6 py-4 last:border-0">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $appointment->service->name }}</p>
                            <p class="text-sm text-slate-500">{{ $appointment->appointment_date->format('D, d M Y') }} at {{ $appointment->appointment_time }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $appointment->statusBadgeClass() }}">{{ $appointment->status }}</span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-slate-500">No appointments yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
