<x-site-layout>
    <x-site-header />

    <section class="relative bg-[#16181D]">
        <img src="{{ asset('images/unit/foto-8.jpg') }}" alt="Showroom Ayoto Nippon" class="absolute inset-0 h-full w-full object-cover opacity-40">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-24">
            <h1 class="text-3xl sm:text-5xl font-bold text-white max-w-2xl">Mobil baru dengan harga OTR jelas per cabang</h1>
            <p class="mt-3 text-base sm:text-lg text-gray-200 max-w-xl">Stok dihitung per unit. Saat ini ada {{ $totalUnit }} unit tersedia di Jakarta dan Bandung.</p>
            <form action="{{ route('katalog.index') }}" method="GET" class="mt-6 max-w-2xl bg-white rounded-2xl p-3 flex flex-col sm:flex-row gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari model atau varian, contoh: Avanza"
                    aria-label="Cari model atau varian" class="flex-1 rounded-xl border-gray-300 min-h-[44px]">
                <select name="cabang" aria-label="Pilih cabang" class="rounded-xl border-gray-300 min-h-[44px]">
                    <option value="">Semua cabang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->kode }}">{{ $branch->nama }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-xl min-h-[44px]">Cari Mobil</button>
            </form>
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('simulasi.form') }}" class="px-4 py-2 text-sm font-semibold text-white border border-white/60 rounded-lg min-h-[44px] inline-flex items-center">Simulasi Kredit</a>
                <a href="{{ route('lacak.form') }}" class="px-4 py-2 text-sm font-semibold text-white border border-white/60 rounded-lg min-h-[44px] inline-flex items-center">Lacak SPK</a>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section id="allbrands" class="mt-12 scroll-mt-20" x-data="{ showAll: window.location.hash === '#allbrands' }" x-init="window.addEventListener('hashchange', () => { if (window.location.hash === '#allbrands') showAll = true; })">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#16181D]">Merek Mobil Populer</h2>
                    <p class="mt-1 text-xs sm:text-sm text-[#4B5563]">Pilih merek favorit untuk melihat model, spesifikasi, dan harga terbaru</p>
                </div>
                <button type="button" @click="showAll = !showAll" class="text-xs sm:text-sm font-semibold text-[#C1121F] hover:underline inline-flex items-center gap-1.5 flex-shrink-0 min-h-[44px]">
                    <span x-text="showAll ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua Merek ({{ $brands->count() }})'"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': showAll }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>
            <div class="mt-5 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3 sm:gap-4">
                @foreach ($brands as $index => $brand)
                    <a href="{{ route('katalog.index', ['brand' => $brand->slug]) }}"
                        x-show="showAll || {{ $index }} < 16"
                        class="bg-white border border-gray-200 rounded-xl sm:rounded-2xl p-3 sm:p-4 flex flex-col items-center justify-center text-center shadow-xs hover:border-[#C1121F] hover:shadow-md transition-all group min-h-[105px]">
                        <div class="h-12 w-full flex items-center justify-center mb-1.5">
                            <img src="{{ $brand->logo_url }}" alt="" aria-hidden="true" class="h-9 w-auto max-w-[70px] object-contain group-hover:scale-105 transition-transform duration-200" loading="lazy">
                        </div>
                        <span class="text-xs sm:text-sm font-semibold text-[#16181D] group-hover:text-[#C1121F] transition-colors truncate w-full">{{ $brand->nama }}</span>
                    </a>
                @endforeach
            </div>
            <div class="mt-4 text-center sm:hidden" x-show="!showAll">
                <button type="button" @click="showAll = true" class="w-full py-2.5 px-4 text-xs font-semibold text-[#C1121F] bg-red-50 hover:bg-red-100 rounded-xl border border-red-200 transition-colors min-h-[44px]">
                    Lihat Semua Merek ({{ $brands->count() }})
                </button>
            </div>
        </section>

        @if ($promos->isNotEmpty())
            <div class="mt-10 flex items-end justify-between">
                <h2 class="text-xl font-bold text-[#16181D]">Promo berjalan</h2>
                <a href="{{ route('promo.index') }}" class="text-sm font-semibold text-[#C1121F] underline min-h-[44px] inline-flex items-center">Semua promo</a>
            </div>
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ($promos as $promo)
                    <a href="{{ route('promo.index') }}" class="relative block rounded-2xl overflow-hidden min-h-[180px] flex items-end">
                        @if ($promo->banner)
                            <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" class="absolute inset-0 h-full w-full object-cover">
                        @endif
                        <span class="absolute inset-0 bg-black/55"></span>
                        <span class="relative p-5">
                            <span class="block font-bold text-white text-lg">{{ $promo->judul }}</span>
                            <span class="block text-xs text-gray-200">{{ $promo->branch->nama ?? 'Semua cabang' }}, sampai {{ $promo->selesai->format('d M Y') }}</span>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        <h2 class="mt-10 text-xl font-bold text-[#16181D]">Layanan kami</h2>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            @foreach ([['test-drive.create', 'Test Drive', 'Coba unit sebelum membeli'], ['trade-in.create', 'Trade-In', 'Tukar tambah mobil lama'], ['servis.create', 'Booking Servis', 'Jadwal servis terjadwal'], ['sparepart.index', 'Sparepart', 'Suku cadang per cabang']] as [$route, $label, $desc])
                <a href="{{ route($route) }}" class="block p-5 border border-gray-200 rounded-xl hover:border-[#16181D]">
                    <span class="block font-bold text-[#16181D]">{{ $label }}</span>
                    <span class="block text-sm text-[#4B5563]">{{ $desc }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
