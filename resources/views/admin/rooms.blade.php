@extends('layouts.dashboard')

@section('title', 'Treatment Rooms')

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Treatment Rooms</h1>
    <p class="mt-1 text-sm text-slate-500">Each active room adds one booking slot of capacity per time session.</p>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="space-y-3">
                @forelse ($rooms as $room)
                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-3"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $room->name }}</p>
                                <p class="text-xs text-slate-500">{{ $room->appointments_count }} appointment(s) all-time</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span @class([
                                'rounded-full px-3 py-1 text-xs font-semibold',
                                'bg-green-50 text-green-700' => $room->is_active,
                                'bg-slate-100 text-slate-500' => ! $room->is_active,
                            ])>{{ $room->is_active ? 'Active' : 'Inactive' }}</span>
                            <form method="POST" action="{{ route('admin.rooms.toggle', $room) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold text-brand-700 hover:underline">
                                    {{ $room->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="rounded-2xl border border-slate-100 bg-white p-6 text-center text-sm text-slate-500">No rooms yet.</p>
                @endforelse
            </div>
        </div>

        <div>
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-slate-900">Add a room</h2>
                <form method="POST" action="{{ route('admin.rooms.store') }}" class="mt-4 space-y-3">
                    @csrf
                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Room name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required placeholder="e.g. Treatment Room 6"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                        @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                        Add room
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
