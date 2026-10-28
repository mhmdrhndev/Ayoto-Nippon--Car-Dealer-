<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>document.documentElement.classList.add('js');</script>

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo-an.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 lg:flex" x-data="{ open: window.matchMedia('(min-width: 1024px)').matches, rail: false }">
            @include('layouts.navigation')

            <div class="flex-1 min-w-0">
                <div class="bg-white border-b border-gray-200 px-4 py-2 flex items-center gap-2 sticky top-0 z-30">
                    <button type="button" @click="window.matchMedia('(min-width: 1024px)').matches ? rail = !rail : open = !open" aria-label="Menu" :aria-expanded="open" class="p-2 rounded-lg text-gray-700 hover:bg-gray-100 min-w-[44px] min-h-[44px] inline-flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="lg:hidden flex items-center gap-2 font-bold text-gray-800">
                        <x-application-logo class="block h-8 w-auto" />
                        Ayoto Nippon
                    </span>
                    <span class="flex-1"></span>
                </div>

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
