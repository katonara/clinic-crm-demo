@props(['name', 'class' => 'h-6 w-6'])

@php
    // Heroicon-style outline paths keyed by name. Centralised so cards stay tidy.
    $paths = [
        'stethoscope' => '<path d="M6 3v5a4 4 0 0 0 8 0V3"/><path d="M6 3H4m4 0h2m6 0h-2m4 0h-2M10 17a6 6 0 0 0 6 6 5 5 0 0 0 5-5v-3"/><circle cx="20" cy="10" r="2"/>',
        'sparkles' => '<path d="M12 3l1.9 4.6L18.5 9.5 13.9 11.4 12 16l-1.9-4.6L5.5 9.5l4.6-1.9L12 3z"/><path d="M19 14l.8 2 .2.0M5 5l.6 1.5"/>',
        'face' => '<circle cx="12" cy="12" r="9"/><path d="M9 10h.01M15 10h.01M9 15c.8.8 2 1.2 3 1.2s2.2-.4 3-1.2"/>',
        'scale' => '<path d="M12 3v18M5 7h14M7 7l-3 6a3 3 0 0 0 6 0L7 7zm10 0l-3 6a3 3 0 0 0 6 0l-3-6z"/>',
        'laser' => '<path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/>',
        'refresh' => '<path d="M21 12a9 9 0 1 1-3-6.7M21 4v4h-4"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 2v4M16 2v4M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>',
        'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
        'dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
        'badge-check' => '<path d="M12 2l2.4 1.7 2.9-.2 1 2.8 2.5 1.5-.9 2.8.9 2.8-2.5 1.5-1 2.8-2.9-.2L12 22l-2.4-1.7-2.9.2-1-2.8L3.2 16l.9-2.8-.9-2.8 2.5-1.5 1-2.8 2.9.2L12 2z"/><path d="M9 12l2 2 4-4"/>',
        'chat' => '<path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.5 8.5 8.5 0 0 1-3.9-.9L3 21l1.9-5.6A8.4 8.4 0 0 1 4 11.5 8.4 8.4 0 0 1 12.5 3 8.4 8.4 0 0 1 21 11.5z"/>',
        'shield-check' => '<path d="M12 3l8 3v6c0 4.5-3.2 7.9-8 9-4.8-1.1-8-4.5-8-9V6l8-3z"/><path d="M9 12l2 2 4-4"/>',
        'lock' => '<rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>',
        'mobile' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'bolt' => '<path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/>',
        'user-edit' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M18.5 11.5l2 2L17 17l-2.5.5.5-2.5 3.5-3.5z"/>',
        'list' => '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>',
        'check' => '<path d="M20 6L9 17l-5-5"/>',
    ];
    $d = $paths[$name] ?? $paths['check'];
@endphp

<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    {!! $d !!}
</svg>
