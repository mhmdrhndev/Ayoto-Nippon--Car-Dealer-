<x-site-layout judul="Halaman Tidak Ditemukan (404)" robots="noindex, nofollow">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-20 text-center">
        <p class="text-8xl font-black tabular-nums text-transparent bg-clip-text bg-gradient-to-b from-[#16181D] dark:from-ink via-muted to-accent-strong tracking-tight">404</p>
        <div class="mx-auto mt-4 h-1 w-16 bg-accent-strong rounded-full shadow-[0_0_12px_rgba(225,29,72,0.6)]" aria-hidden="true"></div>
        <h1 class="mt-6 text-2xl sm:text-3xl font-extrabold text-ink tracking-tight">Halaman Tidak Ditemukan</h1>
        <p class="mt-2 text-sm text-muted leading-relaxed">
            Halaman yang Anda tuju telah dipindahkan atau tautan tidak valid. Temukan kendaraan impian Anda melalui katalog kami.
        </p>

        <form action="{{ route('katalog.index') }}" method="GET" class="mt-8 flex flex-col sm:flex-row gap-2.5">
            <input type="text" name="q" placeholder="Cari model mobil, misal: Avanza, CR-V" aria-label="Cari model atau varian" 
                class="flex-1 bg-surface border border-line rounded-xl text-ink placeholder-gray-500 text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[48px] px-3.5">
            <button type="submit" 
                class="px-6 py-2.5 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[48px] transition-colors shadow-lg shadow-accent/20 flex items-center justify-center">
                Cari Unit
            </button>
        </form>

        <div class="mt-6 flex flex-wrap justify-center gap-2">
            <a href="{{ route('home') }}" class="px-5 py-2.5 text-xs font-bold text-muted hover:text-ink bg-surface border border-line rounded-xl min-h-[44px] inline-flex items-center transition-colors">Beranda</a>
            <a href="{{ route('katalog.index') }}" class="px-5 py-2.5 text-xs font-bold text-muted hover:text-ink bg-surface border border-line rounded-xl min-h-[44px] inline-flex items-center transition-colors">Katalog Mobil</a>
            <a href="{{ route('lacak.form') }}" class="px-5 py-2.5 text-xs font-bold text-muted hover:text-ink bg-surface border border-line rounded-xl min-h-[44px] inline-flex items-center transition-colors">Lacak Status SPK</a>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
