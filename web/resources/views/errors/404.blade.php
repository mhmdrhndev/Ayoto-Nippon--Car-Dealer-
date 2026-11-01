<x-site-layout judul="Halaman Tidak Ditemukan" robots="noindex, nofollow">
    <x-site-header />

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-16 text-center">
        <p class="text-7xl font-bold tabular-nums text-[#16181D]">404</p>
        <div class="mx-auto mt-4 h-1 w-24 bg-[#C1121F] rounded-full" aria-hidden="true"></div>
        <h1 class="mt-4 text-2xl font-bold text-[#16181D]">Jalan ini tidak ada di dealer kami</h1>
        <p class="mt-2 text-sm text-[#4B5563]">Halaman yang Anda cari sudah dipindah atau tidak pernah ada. Unit impian Anda tetap menunggu di katalog.</p>
        <form action="{{ route('katalog.index') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
            <input type="text" name="q" placeholder="Cari model atau varian, contoh: Avanza" aria-label="Cari model atau varian" class="flex-1 rounded-xl border-gray-300 min-h-[44px]">
            <button type="submit" class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-xl min-h-[44px]">Cari Mobil</button>
        </form>
        <div class="mt-4 flex flex-wrap justify-center gap-2">
            <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px] inline-flex items-center">Beranda</a>
            <a href="{{ route('katalog.index') }}" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px] inline-flex items-center">Katalog</a>
            <a href="{{ route('lacak.form') }}" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px] inline-flex items-center">Lacak SPK</a>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
