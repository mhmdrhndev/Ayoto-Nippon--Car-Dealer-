@props([])
<button type="button" onclick="toggleTheme(event)" aria-label="Ganti tema terang atau gelap" title="Ganti tema"
    {{ $attributes->merge(['class' => 'relative inline-flex items-center justify-center min-w-[44px] min-h-[44px] rounded-xl text-muted hover:text-ink hover:bg-surface-2 border border-transparent hover:border-line transition-colors']) }}>
    <span class="theme-pulse pointer-events-none absolute inset-0 rounded-full opacity-0"></span>
    <svg class="absolute w-4 h-4 transition-all duration-500 opacity-100 rotate-0 scale-100 dark:opacity-0 dark:rotate-90 dark:scale-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
        <circle cx="12" cy="12" r="4.2" fill="currentColor" stroke="none"/>
        <path d="M12 2.5v2.2M12 19.3v2.2M4.9 4.9l1.55 1.55M17.55 17.55l1.55 1.55M2.5 12h2.2M19.3 12h2.2M4.9 19.1l1.55-1.55M17.55 6.45l1.55-1.55"/>
    </svg>
    <svg class="absolute w-4 h-4 transition-all duration-500 opacity-0 -rotate-90 scale-50 dark:opacity-100 dark:rotate-0 dark:scale-100" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M20.5 14.6c-1 .4-2.1.6-3.2.6-5 0-9-4-9-9 0-1.6.4-3.1 1.2-4.4a.75.75 0 0 0-.9-1.1A10.5 10.5 0 1 0 21.6 15.5a.75.75 0 0 0-1.1-.9Z"/>
    </svg>
</button>
