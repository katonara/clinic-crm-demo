@props(['eyebrow' => null, 'title', 'subtitle' => null, 'align' => 'center'])

<div @class([
    'max-w-2xl',
    'mx-auto text-center' => $align === 'center',
])>
    @if ($eyebrow)
        <span class="inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-700">
            {{ $eyebrow }}
        </span>
    @endif

    <h2 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
        {{ $title }}
    </h2>

    @if ($subtitle)
        <p class="mt-4 text-base leading-relaxed text-slate-500">
            {{ $subtitle }}
        </p>
    @endif
</div>
