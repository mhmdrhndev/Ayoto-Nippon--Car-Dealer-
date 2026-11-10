<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ayoto Nippon') }}{{ isset($judul) ? ' | '.$judul : '' }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo-an.png') }}">

        @include('partials.theme-script')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased bg-surface selection:bg-accent selection:text-white min-h-screen flex flex-col">
        <div class="min-h-screen w-full flex flex-col justify-between">
            <header class="bg-surface/90 backdrop-blur-md border-b border-line w-full">
                <div class="w-full px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 min-h-[44px] group">
                        <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-9 w-9 object-contain drop-shadow-[0_0_12px_rgba(225,29,72,0.35)] transition-transform group-hover:scale-105">
                        <div class="flex flex-col">
                            <span class="text-base sm:text-lg font-bold tracking-tight text-ink flex items-center gap-1.5">
                                Ayoto Nippon
                                <span class="w-1.5 h-1.5 rounded-full bg-accent-strong"></span>
                            </span>
                            <span class="text-[10px] tracking-widest uppercase text-muted font-medium -mt-0.5">Official Dealer</span>
                        </div>
                    </a>
                    <div class="flex items-center gap-1.5">
                        <x-theme-toggle />
                        <a href="{{ route('home') }}" class="text-xs sm:text-sm font-medium text-muted hover:text-ink min-h-[44px] inline-flex items-center gap-1.5 transition-colors">
                            <span>Kembali ke Beranda</span>
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 w-full px-4 sm:px-6 lg:px-8 py-10 sm:py-16 flex items-center justify-center">
                <div class="w-full max-w-xl bg-surface border border-line rounded-3xl shadow-2xl shadow-black/5 p-6 sm:p-10 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-accent-strong/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative">
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <footer class="w-full px-4 sm:px-6 lg:px-8 py-5 border-t border-line text-center">
                <p class="text-xs text-muted">&copy; {{ date('Y') }} PT Ayoto Nippon. Seluruh hak cipta dilindungi undang-undang.</p>
            </footer>
        </div>
    </body>
</html>
