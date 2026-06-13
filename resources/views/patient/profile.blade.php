@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('content')
    <div class="mx-auto max-w-xl">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">My Profile</h1>
        <p class="mt-1 text-sm text-slate-500">Keep your contact details up to date.</p>

        <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Full name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                    @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled
                        class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-400">
                    <p class="mt-1 text-xs text-slate-400">Email cannot be changed.</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" required
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                        @error('phone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="whatsapp" class="mb-1 block text-sm font-medium text-slate-700">WhatsApp</label>
                        <input id="whatsapp" name="whatsapp" type="text" value="{{ old('whatsapp', $user->whatsapp) }}"
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                        @error('whatsapp') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    Save changes
                </button>
            </form>
        </div>

        {{-- Change password --}}
        <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-base font-semibold text-slate-900">Change password</h2>
            <p class="mt-1 text-sm text-slate-500">Use at least 8 characters.</p>

            <form method="POST" action="{{ route('patient.profile.password') }}" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="current_password" class="mb-1 block text-sm font-medium text-slate-700">Current password</label>
                    <input id="current_password" name="current_password" type="password" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                    @error('current_password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="new_password" class="mb-1 block text-sm font-medium text-slate-700">New password</label>
                        <input id="new_password" name="password" type="password" required
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                        @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Confirm new</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
                    </div>
                </div>

                <button type="submit" class="rounded-xl border border-slate-200 px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Update password
                </button>
            </form>
        </div>
    </div>
@endsection
