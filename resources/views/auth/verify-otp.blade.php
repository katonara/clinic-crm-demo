@extends('layouts.auth')

@section('title', 'Verify Email — ClinicCare')

@section('content')
    <div class="mb-2 flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
    </div>

    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Verify your email</h1>
    <p class="mt-1 text-sm text-slate-500">
        We sent a 6-digit code to <span class="font-medium text-slate-700">{{ auth()->user()->email }}</span>.
        Enter it below to activate your account.
    </p>

    @if (session('status'))
        <div class="mt-4 rounded-lg bg-green-50 px-3 py-2 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    @if (session('dev_otp'))
        <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-800">
            <strong>Dev mode:</strong> mail is logged, not sent. Your code is
            <span class="font-mono font-bold tracking-widest">{{ session('dev_otp') }}</span>.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.verify') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="code" class="mb-1 block text-sm font-medium text-slate-700">Verification code</label>
            <input id="code" name="code" type="text" inputmode="numeric" maxlength="6" required autofocus
                placeholder="______"
                class="w-full rounded-lg border border-slate-200 px-3 py-3 text-center text-2xl font-bold tracking-[0.5em] focus:border-brand-500 focus:ring-2 focus:ring-brand-100 focus:outline-none">
            @error('code') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
            Verify &amp; continue
        </button>
    </form>

    <div class="mt-6 flex items-center justify-between text-sm">
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="font-semibold text-brand-700 hover:underline">Resend code</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-slate-500 hover:text-slate-700">Use a different account</button>
        </form>
    </div>
@endsection
