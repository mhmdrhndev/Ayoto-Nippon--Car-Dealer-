<x-site-layout judul="Akses Terbatas (403)" robots="noindex, nofollow">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-20 text-center">
        <p class="text-8xl font-black tabular-nums text-transparent bg-clip-text bg-gradient-to-b from-[#16181D] via-[#9E0E19] to-[#C1121F] tracking-tight">403</p>
        <div class="mx-auto mt-4 h-1 w-16 bg-[#C1121F] rounded-full shadow-[0_0_12px_rgba(225,29,72,0.6)]" aria-hidden="true"></div>
        <h1 class="mt-6 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Akses Tidak Diizinkan</h1>
        <p class="mt-2 text-sm text-[#4B5563] leading-relaxed">
            Halaman ini membutuhkan hak akses khusus atau login dengan akun terdaftar yang sesuai.
        </p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            @auth
                <a href="{{ route('pesanan.index') }}" class="px-6 py-3 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] inline-flex items-center shadow-lg shadow-[#C1121F]/20 transition-colors">
                    Pesanan Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-3 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] inline-flex items-center shadow-lg shadow-[#C1121F]/20 transition-colors">
                    Masuk ke Akun
                </a>
            @endauth
            <a href="{{ route('home') }}" class="px-6 py-3 font-bold text-sm text-[#4B5563] hover:text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl min-h-[48px] inline-flex items-center transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
