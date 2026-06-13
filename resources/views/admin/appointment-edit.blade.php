@extends('layouts.dashboard')

@section('title', 'Reschedule Appointment')

@section('content')
    <div class="mx-auto max-w-xl"
        x-data="{
            date: '{{ old('appointment_date', $appointment->appointment_date->toDateString()) }}',
            full: [],
            async fetchFull() {
                if (!this.date) { this.full = []; return; }
                try {
                    const url = new URL('{{ route('patient.appointments.availability') }}', window.location.origin);
                    url.searchParams.set('date', this.date);
                    url.searchParams.set('ignore', '{{ $appointment->id }}');
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    this.full = (await res.json()).full || [];
                } catch (e) { this.full = []; }
            }
        }" x-init="fetchFull()">

        <a href="{{ route('admin.appointments') }}" class="text-sm font-semibold text-brand-700 hover:underline">&larr; Back to appointments</a>

        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">Reschedule Appointment #{{ $appointment->id }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            {{ $appointment->user->name }} · {{ $appointment->service->name }}
        </p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}" class="mt-6 space-y-5 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="appointment_date" class="mb-1 block text-sm font-semibold text-slate-700">Date</label>
                    <input id="appointment_date" name="appointment_date" type="date" x-model="date" @change="fetchFull()"
                        value="{{ old('appointment_date', $appointment->appointment_date->toDateString()) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                    @error('appointment_date') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="appointment_time" class="mb-1 block text-sm font-semibold text-slate-700">Time</label>
                    <select id="appointment_time" name="appointment_time" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                        @foreach ($slots as $slot)
                            <option value="{{ $slot }}"
                                @selected(old('appointment_time', $appointment->appointment_time) === $slot)
                                :disabled="full.includes('{{ $slot }}')"
                                x-text="full.includes('{{ $slot }}') ? '{{ $slot }} — full' : '{{ $slot }}'">{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('appointment_time') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">Save changes</button>
                <a href="{{ route('admin.appointments') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
