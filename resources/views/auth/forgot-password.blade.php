@extends('layouts.auth')

@section('title', 'Forgot Password — ClinicCare')

@section('content')
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Forgot your password?</h1>
    <p class="mt-1 text-sm text-slate-500">Enter your email and we'll send you a reset link.</p>

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
            @error('email') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            Email password reset link
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:underline">Back to login</a>
    </p>
@endsection
