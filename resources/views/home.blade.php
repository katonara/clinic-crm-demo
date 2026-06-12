@extends('layouts.app')

@section('title', 'ClinicCare — Book Your Clinic Appointment Online, Anytime')

@php
    $highlights = [
        ['icon' => 'bolt', 'label' => 'Easy online booking'],
        ['icon' => 'lock', 'label' => 'Secure patient registration'],
        ['icon' => 'mail', 'label' => 'Email OTP verification'],
        ['icon' => 'chat', 'label' => 'WhatsApp number support'],
        ['icon' => 'mobile', 'label' => 'Mobile friendly access'],
    ];

    $services = [
        ['icon' => 'stethoscope', 'title' => 'General Consultation', 'desc' => 'Speak with a qualified doctor about everyday health concerns and get expert guidance.'],
        ['icon' => 'sparkles', 'title' => 'Aesthetic Treatment', 'desc' => 'Personalised aesthetic procedures designed to help you look and feel your best.'],
        ['icon' => 'face', 'title' => 'Skin Treatment', 'desc' => 'Targeted care for acne, pigmentation and other common skin conditions.'],
        ['icon' => 'scale', 'title' => 'Weight Management', 'desc' => 'Structured, medically supervised programmes to reach your healthy weight goals.'],
        ['icon' => 'laser', 'title' => 'Laser Treatment', 'desc' => 'Advanced laser therapies for hair removal, skin renewal and more.'],
        ['icon' => 'refresh', 'title' => 'Follow-up Appointment', 'desc' => 'Easy re-booking to track your progress and continue your treatment plan.'],
    ];

    $steps = [
        ['icon' => 'user-edit', 'title' => 'Register an account', 'desc' => 'Create your patient account in just a minute with your basic details.'],
        ['icon' => 'mail', 'title' => 'Verify email with OTP', 'desc' => 'Confirm your email using the secure one-time code we send you.'],
        ['icon' => 'calendar', 'title' => 'Choose service & date', 'desc' => 'Pick the treatment you need and your preferred appointment date.'],
        ['icon' => 'badge-check', 'title' => 'Clinic staff confirms', 'desc' => 'Our team reviews and confirms your appointment slot for you.'],
    ];

    $patientBenefits = [
        'Book appointments online anytime',
        'View your appointment status',
        'Update your basic profile',
        'Receive follow-up reminders',
        'Use WhatsApp number for contact',
    ];

    $adminBenefits = [
        'Manage the appointment schedule',
        'Reduce manual WhatsApp booking',
        'Track patient records',
        'Manage clinic services',
        'View the daily booking list',
    ];

    $features = [
        ['icon' => 'calendar', 'title' => 'Appointment Calendar', 'desc' => 'See all bookings at a glance in a clean monthly and daily view.'],
        ['icon' => 'users', 'title' => 'Patient Management', 'desc' => 'Keep patient details and history organised in one place.'],
        ['icon' => 'dashboard', 'title' => 'Staff Dashboard', 'desc' => 'A focused overview of today\'s appointments and tasks.'],
        ['icon' => 'badge-check', 'title' => 'Booking Status', 'desc' => 'Track each appointment from pending to confirmed and completed.'],
        ['icon' => 'chat', 'title' => 'WhatsApp Contact Field', 'desc' => 'Capture a WhatsApp number for quick patient follow-up.'],
        ['icon' => 'shield-check', 'title' => 'Email OTP Verification', 'desc' => 'Protect accounts with secure one-time-code verification.'],
    ];

    $faqs = [
        ['q' => 'Do patients need to register before booking?', 'a' => 'Yes. Creating a quick account lets patients verify their identity, track appointment status, and receive follow-up reminders securely.'],
        ['q' => 'How does OTP verification work?', 'a' => 'After registering, we email a one-time passcode (OTP). Entering that code confirms the email address belongs to the patient before any booking is made.'],
        ['q' => 'Can patients use a WhatsApp number?', 'a' => 'Absolutely. Patients can provide a WhatsApp number so the clinic team can reach them quickly for confirmations and follow-ups.'],
        ['q' => 'Is the system mobile responsive?', 'a' => 'Yes. The entire experience is built mobile-first, so patients can book comfortably from any phone, tablet or desktop.'],
        ['q' => 'Can clinic staff manage appointments?', 'a' => 'Yes. Staff get a dashboard to view the daily booking list, confirm or reschedule appointments, and manage services and patient records.'],
    ];
@endphp

@section('content')

    {{-- 1. HERO --}}
    <section id="home" class="relative overflow-hidden bg-gradient-to-b from-brand-50 via-white to-white">
        <div class="pointer-events-none absolute -top-24 right-0 h-72 w-72 rounded-full bg-brand-100/60 blur-3xl"></div>
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:gap-8 lg:px-8 lg:py-24">
            {{-- Copy --}}
            <div class="relative">
                <span class="inline-flex items-center gap-2 rounded-full border border-brand-100 bg-white px-3 py-1 text-xs font-semibold text-brand-700 shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                    Modern clinic booking, made simple
                </span>

                <h1 class="mt-6 text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    Book Your Clinic Appointment
                    <span class="text-brand-600">Online, Anytime</span>
                </h1>

                <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-500">
                    A simple and modern clinic booking system that helps patients book appointments
                    faster while helping clinic teams manage schedules more efficiently.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('book') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                        Book Appointment
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Register Account
                    </a>
                </div>

                <div class="mt-8 flex items-center gap-6 text-sm text-slate-500">
                    <div class="flex items-center gap-2"><x-icon name="check" class="h-4 w-4 text-brand-600" /> No phone queue</div>
                    <div class="flex items-center gap-2"><x-icon name="check" class="h-4 w-4 text-brand-600" /> Instant confirmation</div>
                </div>
            </div>

            {{-- Dashboard card preview (pure Tailwind, no images) --}}
            <div class="relative">
                <div class="absolute inset-0 -z-10 translate-x-4 translate-y-4 rounded-3xl bg-brand-600/10"></div>
                <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-xl">
                    {{-- Window bar --}}
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-white"><x-icon name="calendar" class="h-4 w-4" /></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Today's Appointments</p>
                                <p class="text-xs text-slate-400">Wednesday, 12 June</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-600">8 booked</span>
                    </div>

                    {{-- Appointment rows --}}
                    <div class="mt-4 space-y-3">
                        @foreach ([
                            ['t' => '09:00', 'n' => 'Sarah Lim', 's' => 'General Consultation', 'c' => 'green', 'st' => 'Confirmed'],
                            ['t' => '10:30', 'n' => 'Daniel Tan', 's' => 'Skin Treatment', 'c' => 'amber', 'st' => 'Pending'],
                            ['t' => '13:00', 'n' => 'Aisha Rahman', 's' => 'Laser Treatment', 'c' => 'green', 'st' => 'Confirmed'],
                        ] as $row)
                            <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                                <div class="flex w-12 shrink-0 flex-col items-center rounded-lg bg-white py-1.5 text-center shadow-sm">
                                    <span class="text-sm font-bold text-brand-700">{{ explode(':', $row['t'])[0] }}</span>
                                    <span class="text-[10px] text-slate-400">{{ explode(':', $row['t'])[1] }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $row['n'] }}</p>
                                    <p class="truncate text-xs text-slate-400">{{ $row['s'] }}</p>
                                </div>
                                @php $c = $row['c']; @endphp
                                <span @class([
                                    'rounded-full px-2.5 py-1 text-[11px] font-semibold',
                                    'bg-green-50 text-green-600' => $c === 'green',
                                    'bg-amber-50 text-amber-600' => $c === 'amber',
                                ])>{{ $row['st'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Mini stats --}}
                    <div class="mt-4 grid grid-cols-3 gap-3">
                        <div class="rounded-xl bg-brand-50 p-3 text-center">
                            <p class="text-lg font-bold text-brand-700">24</p>
                            <p class="text-[11px] text-slate-500">This week</p>
                        </div>
                        <div class="rounded-xl bg-brand-50 p-3 text-center">
                            <p class="text-lg font-bold text-brand-700">6</p>
                            <p class="text-[11px] text-slate-500">Services</p>
                        </div>
                        <div class="rounded-xl bg-brand-50 p-3 text-center">
                            <p class="text-lg font-bold text-brand-700">98%</p>
                            <p class="text-[11px] text-slate-500">Show rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. TRUST / HIGHLIGHTS --}}
    <section class="border-y border-slate-100 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-4">
                @foreach ($highlights as $h)
                    <div class="flex items-center gap-2 text-sm font-medium text-slate-600">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                            <x-icon :name="$h['icon']" class="h-4 w-4" />
                        </span>
                        {{ $h['label'] }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. SERVICES --}}
    <section id="services" class="bg-slate-50/60 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Our Services"
                title="Clinic services you can book online"
                subtitle="From everyday consultations to specialised treatments — choose what you need and book in a few taps."
            />

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <x-service-card :icon="$service['icon']" :title="$service['title']" :desc="$service['desc']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. HOW IT WORKS --}}
    <section id="how-it-works" class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="How It Works"
                title="Book an appointment in 4 simple steps"
                subtitle="A smooth process designed to get patients booked and confirmed without the back-and-forth."
            />

            <div class="relative mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as $i => $step)
                    <div class="relative text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-8 ring-white">
                            <x-icon :name="$step['icon']" class="h-7 w-7" />
                        </div>
                        <span class="absolute left-1/2 top-0 -translate-x-[3.25rem] -translate-y-1 flex h-7 w-7 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white shadow">
                            {{ $i + 1 }}
                        </span>
                        <h3 class="mt-5 text-base font-semibold text-slate-900">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 5. BENEFITS --}}
    <section id="benefits" class="bg-slate-50/60 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Benefits"
                title="Built for patients and clinic teams alike"
                subtitle="One system that makes booking effortless for patients and scheduling painless for staff."
            />

            <div class="mt-12 grid gap-6 lg:grid-cols-2">
                {{-- For patients --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-600 text-white"><x-icon name="users" class="h-5 w-5" /></span>
                        <h3 class="text-lg font-semibold text-slate-900">For Patients</h3>
                    </div>
                    <ul class="mt-6 space-y-4">
                        @foreach ($patientBenefits as $b)
                            <li class="flex items-start gap-3 text-sm text-slate-600">
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600"><x-icon name="check" class="h-3.5 w-3.5" /></span>
                                {{ $b }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- For admin/staff --}}
                <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-900 text-white"><x-icon name="dashboard" class="h-5 w-5" /></span>
                        <h3 class="text-lg font-semibold text-slate-900">For Clinic Admin &amp; Staff</h3>
                    </div>
                    <ul class="mt-6 space-y-4">
                        @foreach ($adminBenefits as $b)
                            <li class="flex items-start gap-3 text-sm text-slate-600">
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-700"><x-icon name="check" class="h-3.5 w-3.5" /></span>
                                {{ $b }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. FEATURE PREVIEW --}}
    <section class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Feature Preview"
                title="Everything your clinic needs in one place"
                subtitle="A preview of the tools that power the ClinicCare booking experience."
            />

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($features as $feature)
                    <x-feature-card :icon="$feature['icon']" :title="$feature['title']" :desc="$feature['desc']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- 7. FAQ --}}
    <section id="faq" class="bg-slate-50/60 py-20">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="FAQ"
                title="Frequently asked questions"
                subtitle="Everything you need to know about booking and verification."
            />

            <div class="mt-10 space-y-3" x-data="{ active: 0 }">
                @foreach ($faqs as $i => $faq)
                    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                        <button
                            type="button"
                            @click="active === {{ $i }} ? active = null : active = {{ $i }}"
                            class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left"
                            :aria-expanded="active === {{ $i }}"
                        >
                            <span class="text-sm font-semibold text-slate-900">{{ $faq['q'] }}</span>
                            <svg class="h-5 w-5 shrink-0 text-brand-600 transition-transform duration-200" :class="active === {{ $i }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                            </svg>
                        </button>
                        <div x-show="active === {{ $i }}" x-collapse x-cloak>
                            <p class="px-5 pb-5 text-sm leading-relaxed text-slate-500">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 8. CONTACT / CTA --}}
    <section id="contact" class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-700 to-brand-500 px-6 py-14 text-center shadow-xl sm:px-12">
                <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-12 -left-8 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>

                <h2 class="relative text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Ready to book your appointment?
                </h2>
                <p class="relative mx-auto mt-4 max-w-xl text-base leading-relaxed text-brand-50">
                    Join patients who book and manage their clinic visits the easy way. It only takes a minute to get started.
                </p>

                <div class="relative mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                    <a href="{{ route('book') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-brand-700 shadow-sm transition hover:bg-brand-50">
                        Book Appointment
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="https://wa.me/60123456789" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                        <x-icon name="chat" class="h-4 w-4" />
                        Contact Clinic
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
