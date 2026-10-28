<x-site-layout>
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-[#4B5563] hover:underline min-h-[44px] inline-flex items-center">Kembali ke katalog</a>
        @php
            $semuaUnit = $m->variants->flatMap->units;
            $unitSiap = $semuaUnit->where('status', 'Tersedia');
            $fotoUtama = $unitSiap->first()?->foto_utama ?? $semuaUnit->first()?->foto_utama;
            $adaStok = $unitSiap->isNotEmpty();
            $tahunKatalog = $semuaUnit->max('tahun_rakit');
            $cabangTermurah = null;
            $minOtr = null;
            foreach ($m->variants->flatMap->priceLists as $pl) {
                if ($minOtr === null || $pl->otr < $minOtr) {
                    $minOtr = $pl->otr;
                    $cabangTermurah = $pl->branch->nama;
                }
            }
            $estimasi = null;
            if ($minOtr && $bungaMin !== null) {
                $pokok = $minOtr * 0.8;
                $estimasi = (int) round(($pokok + $pokok * $bungaMin / 100 * 48 / 12) / 48);
            }
        @endphp
        <div class="mt-2 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="relative">
                @if ($fotoUtama)
                    <img src="{{ asset($fotoUtama) }}" alt="{{ $m->brand->nama }} {{ $m->nama }}" fetchpriority="high" class="w-full aspect-video object-cover rounded-2xl">
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-2xl flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                @endif
                <div class="absolute top-3 left-3 flex gap-2">
                    <x-status-badge status="{{ $adaStok ? 'Tersedia' : 'Dipesan' }}" />
                </div>
            </div>
            <div>
                <div class="flex items-start justify-between gap-3">
                    <p class="text-sm font-medium text-[#4B5563]">{{ $m->brand->nama }}</p>
                    @if ($cabangStok->isNotEmpty())
                        <p class="text-xs text-[#4B5563] text-right">Terpantau di {{ $cabangStok->count() }} cabang</p>
                    @endif
                </div>
                <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D]">{{ $m->nama }}</h1>
                <p class="mt-2 flex flex-wrap gap-2 text-xs">
                    <span class="px-2 py-1 bg-red-50 border border-red-200 rounded-md font-semibold text-[#C1121F]">{{ $unitSiap->count() }} unit tersedia</span>
                    @if ($kategori)
                        <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $kategori['body'] }}</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $kategori['kursi'] }} kursi</span>
                    @elseif ($m->deskripsi)
                        <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $m->deskripsi }}</span>
                    @endif
                </p>
                <div class="mt-4 p-5 bg-gray-50 border border-gray-200 rounded-2xl">
                    <p class="text-xs text-[#4B5563]">HARGA ON THE ROAD{{ $cabangTermurah ? ' ('.$cabangTermurah.')' : '' }}</p>
                    <p class="mt-1 text-2xl font-bold text-[#16181D] tabular-nums">{{ $minOtr ? 'Mulai Rp '.number_format($minOtr, 0, ',', '.') : 'Mengikuti cabang' }}</p>
                    <p class="mt-1 text-xs text-[#4B5563]">{{ $ringkasan }}</p>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <div class="p-4 bg-white border border-gray-200 rounded-2xl">
                        <p class="text-[11px] text-[#4B5563]">ESTIMASI CICILAN MULAI</p>
                        @if ($estimasi)
                            <p class="mt-1 text-lg font-bold text-[#16181D] tabular-nums">Rp {{ number_format($estimasi, 0, ',', '.') }}<span class="text-xs font-medium">/bln</span></p>
                            <p class="text-[11px] text-[#4B5563]">Tenor 48 bln, DP 20%, estimasi kasar</p>
                        @else
                            <p class="mt-1 text-sm text-[#4B5563]">Ikuti simulasi kredit</p>
                        @endif
                    </div>
                    <div class="p-4 bg-white border border-gray-200 rounded-2xl">
                        <p class="text-[11px] text-[#4B5563]">STATUS ALOKASI UNIT</p>
                        @if ($cabangStok->isNotEmpty())
                            <p class="mt-1 text-lg font-bold text-[#16181D] tabular-nums">{{ $unitSiap->count() }} unit</p>
                            <p class="text-[11px] text-[#4B5563]">{{ $cabangStok->join(', ') }}</p>
                        @else
                            <p class="mt-1 text-sm text-[#4B5563]">Belum ada stok terpantau</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-10 text-xl font-bold text-[#16181D]">Pilih Varian ({{ $m->variants->count() }})</h2>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($m->variants as $variant)
                @php
                    $unitSiapVarian = $variant->units->where('status', 'Tersedia');
                    $foto = $unitSiapVarian->first()?->foto_utama ?? $variant->units->first()?->foto_utama;
                    $mulai = $variant->priceLists->min('otr');
                    $cabangVarian = $unitSiapVarian->map(fn ($u) => $u->branch->nama)->unique()->values();
                    $tahunVarian = $unitSiapVarian->max('tahun_rakit');
                @endphp
                <a href="{{ route('katalog.show', $variant->slug) }}" class="border border-gray-200 rounded-2xl overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-lg focus-visible:-translate-y-1 focus-visible:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16181D]">
                    <div class="relative">
                        @if ($foto)
                            <img src="{{ asset($foto) }}" alt="{{ $variant->nama }}" class="h-44 w-full object-cover" loading="lazy">
                        @else
                            <div class="h-44 w-full bg-gray-100 flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                        @endif

                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-[#16181D]">{{ $variant->nama }}</h3>
                            @if ($tahunVarian)
                                <span class="text-xs font-semibold text-[#4B5563] tabular-nums flex-shrink-0">{{ $tahunVarian }}</span>
                            @endif
                        </div>
                        <p class="mt-2 flex flex-wrap gap-2 text-xs">
                            <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->transmisi }}</span>
                            <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->bbm }}</span>
                        </p>
                        <dl class="mt-3 text-xs border-t border-gray-100">
                            <div class="flex justify-between gap-2 py-1.5">
                                <dt class="text-[#4B5563]">Tersedia di</dt>
                                <dd class="font-semibold text-right text-[#16181D]">{{ $cabangVarian->isNotEmpty() ? $cabangVarian->join(' dan ') : '-' }}</dd>
                            </div>
                        </dl>
                        <p class="mt-3 text-xs text-[#4B5563]">Harga OTR{{ $cabangVarian->isNotEmpty() ? ' '.$cabangVarian->first() : '' }}</p>
                        <p class="text-lg font-bold text-[#16181D] tabular-nums">
                            {{ $mulai ? 'Rp '.number_format($mulai, 0, ',', '.') : 'Harga belum tersedia' }}
                        </p>
                        <span class="mt-4 px-4 py-2 inline-flex items-center justify-center text-sm font-semibold text-white bg-[#16181D] rounded-lg min-h-[44px]">Lihat Detail</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
