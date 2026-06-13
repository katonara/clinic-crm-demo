@extends('layouts.dashboard')

@section('title', 'Appointments')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Appointments</h1>
            <p class="mt-1 text-sm text-slate-500">Manage and confirm patient bookings.</p>
        </div>
        <a href="{{ route('admin.appointments.export', request()->only('status', 'date')) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"/></svg>
            Export CSV
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.appointments') }}" class="mt-6 flex flex-wrap items-end gap-3">
        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-500">Status</label>
            <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                <option value="">All</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected($currentStatus === $status) class="capitalize">{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-500">Date</label>
            <input type="date" name="date" value="{{ $currentDate }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
        </div>
        <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">Filter</button>
        @if ($currentStatus || $currentDate)
            <a href="{{ route('admin.appointments') }}" class="px-2 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Patient</th>
                        <th class="px-6 py-3 font-semibold">Service</th>
                        <th class="px-6 py-3 font-semibold">Date &amp; Time</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($appointments as $appointment)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $appointment->user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $appointment->user->phone }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $appointment->service->name }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $appointment->appointment_date->format('d M Y') }}
                                <span class="text-slate-400">· {{ $appointment->appointment_time }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold capitalize {{ $appointment->statusBadgeClass() }}">{{ $appointment->status }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($url = $appointment->user->whatsappUrl('Hi ' . $appointment->user->name . ', regarding your ' . $appointment->service->name . ' appointment on ' . $appointment->appointment_date->format('d M Y') . ' at ' . $appointment->appointment_time . '.'))
                                        <a href="{{ $url }}" target="_blank" rel="noopener" title="Message on WhatsApp"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 text-green-600 transition hover:bg-green-100">
                                            <x-icon name="chat" class="h-4 w-4" />
                                        </a>
                                    @endif
                                    @include('admin.partials.status-actions', ['appointment' => $appointment])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
@endsection
