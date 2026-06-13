@extends('layouts.dashboard')

@php $isEdit = (bool) $appointment; @endphp

@section('title', $isEdit ? 'Reschedule Appointment' : 'Book Appointment')

@section('content')
    <div class="mx-auto max-w-2xl"
        x-data="{
            service: '{{ old('service_id', $selectedService) }}',
            date: '{{ old('appointment_date', $appointment?->appointment_date?->toDateString()) }}',
            taken: [],
            loading: false,
            async fetchTaken() {
                if (!this.date) { this.taken = []; return; }
                this.loading = true;
                try {
                    const url = new URL('{{ route('patient.appointments.availability') }}', window.location.origin);
                    url.searchParams.set('date', this.date);
                    @if ($isEdit) url.searchParams.set('ignore', '{{ $appointment->id }}'); @endif
                    const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                    this.taken = (await res.json()).full || [];
                } catch (e) { this.taken = []; } finally { this.loading = false; }
            }
        }"
        x-init="fetchTaken()">

        <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $isEdit ? 'Reschedule Appointment' : 'Book an Appointment' }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            {{ $isEdit ? 'Pick a new date and time for your appointment.' : "Choose a service, pick a date and time, and we'll confirm it shortly." }}
        </p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST"
            action="{{ $isEdit ? route('patient.appointments.update', $appointment) : route('patient.appointments.store') }}"
            class="mt-6 space-y-6">
            @csrf
            @if ($isEdit) @method('PATCH') @endif

            {{-- Service --}}
            @if ($isEdit)
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Service</label>
                    <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                            <x-icon :name="$appointment->service->icon" class="h-5 w-5" />
                        </span>
                        <span class="text-sm font-semibold text-slate-900">{{ $appointment->service->name }}</span>
                        <span class="ml-auto text-xs text-slate-400">Service can't be changed when rescheduling</span>
                    </div>
                </div>
            @else
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Select a service</label>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach ($services as $service)
                            <label
                                :class="service === '{{ $service->id }}' ? 'border-brand-500 ring-2 ring-brand-100' : 'border-slate-200 hover:border-brand-200'"
                                class="flex cursor-pointer items-start gap-3 rounded-xl border bg-white p-4 transition">
                                <input type="radio" name="service_id" value="{{ $service->id }}" x-model="service" class="sr-only" required>
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                                    <x-icon :name="$service->icon" class="h-5 w-5" />
                                </span>
                                <span>
                                    <span class="block text-sm font-semibold text-slate-900">{{ $service->name }}</span>
                                    <span class="mt-0.5 block text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($service->description, 60) }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('service_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="appointment_date" class="mb-1 block text-sm font-semibold text-slate-700">Preferred date</label>
                    <input id="appointment_date" name="appointment_date" type="date"
                        x-model="date" @change="fetchTaken()"
                        min="{{ now()->toDateString() }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                    @error('appointment_date') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="appointment_time" class="mb-1 block text-sm font-semibold text-slate-700">
                        Preferred time <span x-show="loading" class="text-xs text-slate-400">(checking…)</span>
                    </label>
                    <select id="appointment_time" name="appointment_time" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                        <option value="">Select a time</option>
                        @foreach ($slots as $slot)
                            <option value="{{ $slot }}"
                                @selected(old('appointment_time', $appointment?->appointment_time) === $slot)
                                :disabled="taken.includes('{{ $slot }}')"
                                x-text="taken.includes('{{ $slot }}') ? '{{ $slot }} — full' : '{{ $slot }}'">{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('appointment_time') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="notes" class="mb-1 block text-sm font-semibold text-slate-700">Notes <span class="text-slate-400">(optional)</span></label>
                <textarea id="notes" name="notes" rows="3" placeholder="Anything our team should know?"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">{{ old('notes', $appointment?->notes) }}</textarea>
                @error('notes') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    {{ $isEdit ? 'Save changes' : 'Submit booking' }}
                </button>
                <a href="{{ route('patient.dashboard') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
