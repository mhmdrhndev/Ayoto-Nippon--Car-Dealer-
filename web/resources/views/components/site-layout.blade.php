@props(['judul' => null, 'deskripsi' => null, 'robots' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>document.documentElement.classList.add('js');</script>
        @include('partials.theme-script')

        <title>{{ config('app.name', 'Ayoto Nippon') }}{{ $judul ? ' | '.$judul : '' }}</title>
        @if ($deskripsi)<meta name="description" content="{{ $deskripsi }}">@endif
        @if ($robots)<meta name="robots" content="{{ $robots }}">@endif
        <link rel="icon" type="image/png" href="{{ asset('images/logo-an.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased bg-surface selection:bg-accent selection:text-white min-h-screen flex flex-col">
        {{ $slot }}
    </body>
</html>
