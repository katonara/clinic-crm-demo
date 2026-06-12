<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'ClinicCare — Online Clinic Booking System')</title>
    <meta name="description" content="@yield('meta_description', 'Book your clinic appointment online, anytime. A simple, modern clinic booking system for patients and clinic teams.')">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    {{-- Compiled Tailwind + Alpine via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-slate-700 antialiased">
    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
