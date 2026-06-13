@extends('layouts.dashboard')

@section('title', 'Patients')

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Patient Records</h1>
    <p class="mt-1 text-sm text-slate-500">View registered patients and their booking history.</p>

    <form method="GET" action="{{ route('admin.patients') }}" class="mt-6 flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search by name or email"
            class="w-full max-w-sm rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
        <button type="submit" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">Search</button>
        @if ($search)
            <a href="{{ route('admin.patients') }}" class="px-2 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">Clear</a>
        @endif
    </form>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Name</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Phone</th>
                        <th class="px-6 py-3 font-semibold">Appointments</th>
                        <th class="px-6 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($patients as $patient)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $patient->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $patient->email }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $patient->phone }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ $patient->appointments_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.patients.show', $patient) }}" class="text-sm font-semibold text-brand-700 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No patients found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $patients->links() }}</div>
@endsection
