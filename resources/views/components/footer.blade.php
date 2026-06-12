@props(['brand' => 'ClinicCare'])

<footer class="border-t border-slate-100 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-600 text-white">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h5v5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
                        </svg>
                    </span>
                    <span class="text-lg font-bold tracking-tight text-slate-900">{{ $brand }}</span>
                </div>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-500">
                    A simple and modern clinic booking system that helps patients book appointments
                    faster while helping clinic teams manage schedules more efficiently.
                </p>
            </div>

            {{-- Quick links --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-900">Quick Links</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="#services" class="text-slate-500 transition hover:text-brand-700">Services</a></li>
                    <li><a href="#how-it-works" class="text-slate-500 transition hover:text-brand-700">How It Works</a></li>
                    <li><a href="#benefits" class="text-slate-500 transition hover:text-brand-700">Benefits</a></li>
                    <li><a href="#faq" class="text-slate-500 transition hover:text-brand-700">FAQ</a></li>
                    <li><a href="{{ route('book') }}" class="text-slate-500 transition hover:text-brand-700">Book Appointment</a></li>
                </ul>
            </div>

            {{-- Contact placeholder --}}
            <div>
                <h3 class="text-sm font-semibold text-slate-900">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm text-slate-500">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><circle cx="12" cy="11" r="2.5"/></svg>
                        <span>123 Wellness Ave, City Center</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11 11 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>WhatsApp: +60 12-345 6789</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>hello@cliniccare.example</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col items-center justify-between gap-3 border-t border-slate-200 pt-6 sm:flex-row">
            <p class="text-sm text-slate-400">&copy; {{ date('Y') }} {{ $brand }}. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="text-sm font-medium text-slate-500 transition hover:text-brand-700">Privacy Policy</a>
                <span class="text-xs text-slate-400">Built with Laravel &amp; Tailwind CSS</span>
            </div>
        </div>
    </div>
</footer>
