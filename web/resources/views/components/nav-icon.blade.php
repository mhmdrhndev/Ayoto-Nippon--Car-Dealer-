@props(['name'])
@php
    $peta = [
        'grid' => '<rect x="4" y="4" width="7" height="7" rx="1.5"/><rect x="13" y="4" width="7" height="7" rx="1.5"/><rect x="4" y="13" width="7" height="7" rx="1.5"/><rect x="13" y="13" width="7" height="7" rx="1.5"/>',
        'check' => '<circle cx="12" cy="12" r="8"/><path d="M8.5 12.5l2.5 2.5 4.5-5"/>',
        'users' => '<circle cx="9" cy="8" r="3"/><path d="M3 20c0-3.5 2.7-5.5 6-5.5s6 2 6 5.5"/><circle cx="17" cy="9" r="2.5"/><path d="M16.5 14.5c2.3.3 4.5 1.8 4.5 5.5"/>',
        'box' => '<path d="M21 8l-9-5-9 5v8l9 5 9-5z"/><path d="M3 8l9 5 9-5"/><path d="M12 13v8"/>',
        'calendar' => '<rect x="4" y="6" width="16" height="14" rx="2"/><path d="M4 10h16M8 3v5M16 3v5"/>',
        'swap' => '<path d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>',
        'wrench' => '<path d="M14.5 6.5a4 4 0 0 0-5.6 5.6L4 17l3 3 4.9-4.9a4 4 0 0 0 5.6-5.6l-2.7 2.7-2.5-2.5z"/>',
        'clipboard' => '<rect x="5" y="5" width="14" height="16" rx="2"/><path d="M9 5a2 2 0 0 1 6 0M9 11h6M9 15h4"/>',
        'tag' => '<path d="M20 12l-8 8-9-9V4h7z"/><circle cx="7.5" cy="7.5" r="1"/>',
        'car' => '<path d="M4 16v3m16-3v3M5 16l1.5-5h11L19 16M4 16h16"/><circle cx="8" cy="18.5" r="1.5"/><circle cx="16" cy="18.5" r="1.5"/>',
        'layers' => '<path d="M12 3l9 5-9 5-9-5z"/><path d="M3 13l9 5 9-5"/>',
        'drop' => '<path d="M12 3s6 6.6 6 11a6 6 0 0 1-12 0c0-4.4 6-11 6-11z"/>',
        'bank' => '<path d="M3 10l9-6 9 6M5 10v8M10 10v8M14 10v8M19 10v8M3 20h18"/>',
        'pin' => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
        'percent' => '<path d="M19 5L5 19"/><circle cx="7" cy="7" r="2.5"/><circle cx="17" cy="17" r="2.5"/>',
        'doc' => '<path d="M7 3h7l4 4v14H7z"/><path d="M14 3v4h4M10 12h5M10 16h5"/>',
        'image' => '<rect x="4" y="5" width="16" height="14" rx="2"/><circle cx="9" cy="10" r="1.5"/><path d="M4 17l5-4 4 3 3-2 4 3"/>',
        'chart' => '<path d="M4 20h16M7 20v-6M12 20V6M17 20v-9"/>',
        'user' => '<circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.9 3.1-6 7-6s7 2.1 7 6"/>',
        'logout' => '<path d="M14 4H5v16h9M11 8l4 4-4 4M15 12H3"/>',
        'chevron' => '<path d="M6 9l6 6 6-6"/>',
    ];
@endphp
<svg {{ $attributes->merge(['class' => 'w-5 h-5 shrink-0']) }} fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">{!! $peta[$name] ?? '' !!}</svg>
