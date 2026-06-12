@props(['brand' => 'ClinicCare'])

@php
    $links = [
        ['label' => 'Home', 'href' => '#home'],
        ['label' => 'Services', 'href' => '#services'],
        ['label' => 'How It Works', 'href' => '#how-it-works'],
        ['label' => 'Benefits', 'href' => '#benefits'],
        ['label' => 'FAQ', 'href' => '#faq'],
        ['label' => 'Contact', 'href' => '#contact'],
    ];
@endphp

<header
    x-data="{ open: false, scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 8)"
    class="sticky top-0 z-50 w-full border-b border-slate-100 bg-white/90 backdrop-blur transition-shadow"
    :class="scrolled ? 'shadow-sm' : ''"
>
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        {{-- Logo / brand --}}
        <a href="#home" class="flex shrink-0 items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white shadow-sm">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h5v5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
                </svg>
            </span>
            <span class="text-lg font-bold tracking-tight text-slate-900">{{ $brand }}</span>
        </a>

        {{-- Desktop nav links --}}
        <div class="hidden items-center gap-1 lg:flex">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-brand-50 hover:text-brand-700">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Desktop CTAs --}}
        <div class="hidden items-center gap-2 lg:flex">
            @guest
                <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 transition hover:text-brand-700">
                    Login
                </a>
                <a href="{{ route('register') }}" class="rounded-lg border border-brand-200 px-4 py-2 text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                    Register
                </a>
                <a href="{{ route('book') }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    Book Appointment
                </a>
            @else
                <a href="{{ auth()->user()->isStaff() ? route('admin.dashboard') : route('patient.dashboard') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 transition hover:text-brand-700">
                    Dashboard
                </a>
                <a href="{{ route('book') }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                    Book Appointment
                </a>
            @endguest
        </div>

        {{-- Mobile hamburger --}}
        <button
            type="button"
            @click="open = !open"
            class="inline-flex items-center justify-center rounded-lg p-2 text-slate-700 transition hover:bg-brand-50 lg:hidden"
            :aria-expanded="open"
            aria-label="Toggle navigation menu"
        >
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </nav>

    {{-- Mobile menu panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition.origin.top
        @click.outside="open = false"
        class="border-t border-slate-100 bg-white lg:hidden"
    >
        <div class="space-y-1 px-4 py-4 sm:px-6">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" @click="open = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-700 transition hover:bg-brand-50 hover:text-brand-700">
                    {{ $link['label'] }}
                </a>
            @endforeach

            <div class="mt-4 grid gap-2 border-t border-slate-100 pt-4">
                @guest
                    <a href="{{ route('login') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="rounded-lg border border-brand-200 px-4 py-2.5 text-center text-sm font-semibold text-brand-700 transition hover:bg-brand-50">
                        Register
                    </a>
                    <a href="{{ route('book') }}" class="rounded-lg bg-brand-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                        Book Appointment
                    </a>
                @else
                    <a href="{{ auth()->user()->isStaff() ? route('admin.dashboard') : route('patient.dashboard') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Dashboard
                    </a>
                    <a href="{{ route('book') }}" class="rounded-lg bg-brand-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                        Book Appointment
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>
