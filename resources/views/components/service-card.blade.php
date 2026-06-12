@props(['icon' => 'check', 'title', 'desc'])

<div class="group flex h-full flex-col rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-brand-100 hover:shadow-lg">
    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white">
        <x-icon :name="$icon" class="h-6 w-6" />
    </div>

    <h3 class="mt-5 text-lg font-semibold text-slate-900">{{ $title }}</h3>
    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-500">{{ $desc }}</p>

    <a href="{{ route('book') }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700 transition group-hover:gap-2.5">
        Book Now
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
    </a>
</div>
