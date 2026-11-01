<x-site-layout judul="Akses Ditolak" robots="noindex, nofollow">
    <x-site-header />

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-16 text-center">
        <p class="text-7xl font-bold tabular-nums text-[#16181D]">403</p>
        <div class="mx-auto mt-4 h-1 w-24 bg-[#C1121F] rounded-full" aria-hidden="true"></div>
        <h1 class="mt-4 text-2xl font-bold text-[#16181D]">Ruang ini khusus pemiliknya</h1>
        <p class="mt-2 text-sm text-[#4B5563]">Anda masuk dengan akun yang tidak berhak membuka halaman ini. Masuk dengan akun yang benar atau kembali ke pesanan Anda.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-2">
            @auth
                <a href="{{ route('pesanan.index') }}" class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-xl min-h-[44px] inline-flex items-center">Pesanan Saya</a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-xl min-h-[44px] inline-flex items-center">Masuk</a>
            @endauth
            <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px] inline-flex items-center">Beranda</a>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
