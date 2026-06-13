<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — ClinicCare</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-700 antialiased">
    @php
        $user = auth()->user();
        $nav = $user->isStaff()
            ? [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
                ['label' => 'Appointments', 'route' => 'admin.appointments'],
                ['label' => 'Calendar', 'route' => 'admin.calendar'],
                ['label' => 'Patients', 'route' => 'admin.patients'],
                ['label' => 'Services', 'route' => 'admin.services'],
            ]
            : [
                ['label' => 'Dashboard', 'route' => 'patient.dashboard'],
                ['label' => 'Book Appointment', 'route' => 'book'],
                ['label' => 'My Profile', 'route' => 'patient.profile'],
            ];
    @endphp

    <header x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-8">
                <a href="{{ route($user->isStaff() ? 'admin.dashboard' : 'patient.dashboard') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h5v5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
                        </svg>
                    </span>
                    <span class="text-lg font-bold tracking-tight text-slate-900">ClinicCare</span>
                    @if ($user->isStaff())
                        <span class="rounded-full bg-slate-900 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-white">Staff</span>
                    @endif
                </a>

                <nav class="hidden items-center gap-1 md:flex">
                    @foreach ($nav as $item)
                        <a href="{{ route($item['route']) }}" @class([
                            'rounded-lg px-3 py-2 text-sm font-medium transition',
                            'bg-brand-50 text-brand-700' => request()->routeIs($item['route']),
                            'text-slate-600 hover:bg-slate-100' => ! request()->routeIs($item['route']),
                        ])>{{ $item['label'] }}</a>
                    @endforeach
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-slate-500 sm:inline">{{ $user->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Logout
                    </button>
                </form>
                <button @click="open = !open" class="rounded-lg p-2 text-slate-700 hover:bg-slate-100 md:hidden" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div x-show="open" x-cloak class="border-t border-slate-100 bg-white md:hidden">
            <nav class="space-y-1 px-4 py-3">
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-100 bg-green-50 px-4 py-3 text-sm text-green-800">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
