@extends('layouts.app')

@section('title', ($title ?? 'Coming Soon') . ' — ClinicCare')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-b from-brand-50 to-white">
        <div class="mx-auto flex min-h-[60vh] max-w-3xl flex-col items-center justify-center px-4 py-24 text-center sm:px-6">
            <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-600 text-white shadow-lg">
                <x-icon name="clock" class="h-8 w-8" />
            </span>

            <h1 class="mt-8 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                {{ $title ?? 'Coming Soon' }}
            </h1>

            <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-500">
                {{ $message ?? 'This feature is part of an upcoming phase of the ClinicCare booking system.' }}
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/></svg>
                    Back to Home
                </a>
                <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Contact Clinic
                </a>
            </div>
        </div>
    </section>
@endsection
