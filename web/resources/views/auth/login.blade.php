@php
    $staf = ($portal ?? 'pelanggan') === 'staf';
@endphp

<x-guest-layout :judul="$staf ? 'Login Staf' : 'Masuk Akun'">
    <x-auth-session-status class="mb-4 text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 p-3 rounded-xl text-xs" :status="session('status')" />

    <div class="mb-6 pb-6 border-b border-[#E5E7EB] flex items-center justify-between">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F] rounded-xl">
            <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-11 w-11 object-contain drop-shadow-[0_0_12px_rgba(225,29,72,0.25)] transition-transform group-hover:scale-105">
            <div class="flex flex-col">
                <span class="text-lg font-extrabold tracking-tight text-[#16181D] group-hover:text-[#C1121F] flex items-center gap-1.5 transition-colors">
                    Ayoto Nippon
                    <span class="w-2 h-2 rounded-full bg-[#C1121F]"></span>
                </span>
                <span class="text-[10px] tracking-widest uppercase text-[#4B5563] font-semibold -mt-0.5">Official Dealer</span>
            </div>
        </a>
        <span class="text-[11px] font-semibold tracking-wider text-[#C1121F] uppercase px-2.5 py-1 rounded-md bg-[#C1121F]/10 border border-[#C1121F]/20">
            {{ $staf ? 'Staf' : 'Pelanggan' }}
        </span>
    </div>

    <div>
        <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">{{ $staf ? 'Portal Internal Staf' : 'Portal Pelanggan' }}</p>
        <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">{{ $staf ? 'Masuk ke Portal Staf' : 'Selamat Datang Kembali' }}</h1>
        <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
            {{ $staf ? 'Akses sistem untuk sales consultant, admin cabang, service advisor, dan mekanik.' : 'Pantau status pemesanan SPK, jadwal test drive, servis berkala, dan riwayat transaksi Anda.' }}
        </p>
    </div>

    <form method="POST" action="{{ $staf ? route('login.staf.store') : route('login.store') }}" class="mt-8 space-y-5">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="nama@email.com"
                    class="mt-1.5 block w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                @error('email')
                    <p class="mt-1.5 text-xs text-[#C1121F] font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="mt-1.5 block w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                @error('password')
                    <p class="mt-1.5 text-xs text-[#C1121F] font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center min-h-[36px] cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="rounded bg-[#FFFFFF] border-[#E5E7EB] text-[#C1121F] focus:ring-[#C1121F] focus:ring-offset-0">
                <span class="ms-2 text-[#4B5563]">Ingat sesi saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-[#4B5563] hover:text-[#16181D] transition-colors">Lupa kata sandi?</a>
            @endif
        </div>

        <button type="submit" 
            class="w-full py-3.5 px-6 text-sm font-bold text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
            Masuk ke Akun
        </button>
    </form>

    <div class="mt-8 pt-5 border-t border-[#E5E7EB] text-xs text-[#4B5563] leading-relaxed">
        @if ($staf)
            <p>Akun pelanggan pribadi? <a href="{{ route('login') }}" class="font-semibold text-[#16181D] hover:text-[#C1121F] underline underline-offset-2 transition-colors">Masuk portal pelanggan</a></p>
            <p class="mt-1.5 text-gray-500">Kredensial staf diterbitkan oleh pimpinan cabang resmi.</p>
        @else
            <p>Belum memiliki akun pelanggan? <a href="{{ route('register') }}" class="font-semibold text-[#16181D] hover:text-[#C1121F] underline underline-offset-2 transition-colors">Daftar sekarang</a></p>
        @endif
    </div>
</x-guest-layout>
