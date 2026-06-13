@extends('layouts.auth')

@section('title', 'Log In — ClinicCare')

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Welcome back</h1>
    <p class="mt-1 text-sm text-slate-500">Log in to manage your appointments.</p>

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="mb-1 flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand-700 hover:underline">Forgot password?</a>
            </div>
            <input id="password" name="password" type="password" required
                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
            @error('password') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
            Remember me
        </label>

        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            Log in
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-semibold text-brand-700 hover:underline">Register</a>
    </p>
@endsection
