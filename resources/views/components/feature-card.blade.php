@props(['icon' => 'check', 'title', 'desc'])

<div class="flex h-full items-start gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:shadow-md">
    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
        <x-icon :name="$icon" class="h-5 w-5" />
    </div>
    <div>
        <h3 class="text-sm font-semibold text-slate-900">{{ $title }}</h3>
        <p class="mt-1 text-sm leading-relaxed text-slate-500">{{ $desc }}</p>
    </div>
</div>
