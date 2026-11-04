<x-site-layout judul="{{ $m->brand->nama }} {{ $m->nama }}" deskripsi="Pilih varian {{ $m->nama }} dengan harga OTR dan estimasi cicilan di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-10">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-[#4B5563] hover:text-[#16181D] min-h-[44px] inline-flex items-center gap-2 transition-colors">
            <span>Kembali ke Katalog</span>
        </a>

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

        <!-- Hero Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7">
                <div class="relative bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-2xl shadow-black/5">
                    @if ($fotoUtama)
                        <img src="{{ asset($fotoUtama) }}" alt="{{ $m->brand->nama }} {{ $m->nama }}" fetchpriority="high" class="w-full aspect-[16/10] object-cover">
                    @else
                        <div class="w-full aspect-[16/10] bg-[#FFFFFF] rounded-3xl flex items-center justify-center text-sm text-gray-500">Foto menyusul</div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <x-status-badge status="{{ $adaStok ? 'Tersedia' : 'Dipesan' }}" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
                <div>
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#C1121F]">{{ $m->brand->nama }}</p>
                        @if ($cabangStok->isNotEmpty())
                            <span class="text-xs font-medium text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-0.5 rounded-full">Tersedia di {{ $cabangStok->count() }} cabang</span>
                        @endif
                    </div>
                    <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">{{ $m->nama }}</h1>

                    <div class="mt-3 flex flex-wrap gap-2 text-xs">
                        <span class="px-3 py-1 bg-rose-500/10 border border-rose-500/20 rounded-lg font-semibold text-[#C1121F] tabular-nums">{{ $unitSiap->count() }} unit siap kirim</span>
                        @if ($kategori)
                            <span class="px-3 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#4B5563] font-medium">{{ $kategori['body'] }}</span>
                            <span class="px-3 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#4B5563] font-medium">{{ $kategori['kursi'] }} Kursi</span>
                        @elseif ($m->deskripsi)
                            <span class="px-3 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#4B5563] font-medium">{{ $m->deskripsi }}</span>
                        @endif
                    </div>

                    <!-- Price Card -->
                    <div class="mt-6 p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl shadow-xl">
                        <p class="text-xs font-medium text-[#4B5563] uppercase tracking-wider">Harga On The Road{{ $cabangTermurah ? ' ('.$cabangTermurah.')' : '' }}</p>
                        <p class="mt-1 text-3xl font-extrabold text-[#16181D] tabular-nums tracking-tight">
                            {{ $minOtr ? 'Mulai Rp '.number_format($minOtr, 0, ',', '.') : 'Hubungi Cabang' }}
                        </p>
                        <p class="mt-2 text-xs text-[#4B5563] leading-relaxed">{{ $ringkasan }}</p>
                    </div>

                    <!-- Sub stats -->
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <div class="p-4 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl">
                            <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Estimasi Cicilan</p>
                            @if ($estimasi)
                                <p class="mt-1 text-lg font-bold text-[#16181D] tabular-nums">Rp {{ number_format($estimasi, 0, ',', '.') }}<span class="text-xs font-normal text-[#4B5563]">/bln</span></p>
                                <p class="mt-0.5 text-[11px] text-gray-500">Tenor 48 bln, DP 20%</p>
                            @else
                                <p class="mt-1 text-sm text-[#4B5563]">Hitung simulasi kredit</p>
                            @endif
                        </div>
                        <div class="p-4 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl">
                            <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Alokasi Wilayah</p>
                            @if ($cabangStok->isNotEmpty())
                                <p class="mt-1 text-lg font-bold text-[#16181D] tabular-nums">{{ $unitSiap->count() }} unit</p>
                                <p class="mt-0.5 text-[11px] text-[#4B5563] truncate">{{ $cabangStok->join(', ') }}</p>
                            @else
                                <p class="mt-1 text-sm text-[#4B5563]">Belum ada alokasi</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Variants Section -->
        <div class="pt-6 border-t border-[#E5E7EB]">
            <div class="flex items-center justify-between pb-4">
                <div>
                    <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pilihan Trim & Konfigurasi</p>
                    <h2 class="mt-1 text-2xl font-bold text-[#16181D] tracking-tight">Daftar Varian {{ $m->nama }} ({{ $m->variants->count() }})</h2>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($m->variants as $variant)
                    @php
                        $unitSiapVarian = $variant->units->where('status', 'Tersedia');
                        $foto = $unitSiapVarian->first()?->foto_utama ?? $variant->units->first()?->foto_utama;
                        $mulai = $variant->priceLists->min('otr');
                        $cabangVarian = $unitSiapVarian->map(fn ($u) => $u->branch->nama)->unique()->values();
                        $tahunVarian = $unitSiapVarian->max('tahun_rakit');
                    @endphp
                    <a href="{{ route('katalog.show', $variant->slug) }}" 
                       class="group bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden flex flex-col justify-between transition-all duration-300 hover:border-[#C1121F] hover:shadow-2xl hover:shadow-black/5 hover:-translate-y-1 focus-visible:-translate-y-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">
                        <div class="relative bg-[#FFFFFF] overflow-hidden">
                            @if ($foto)
                                <img src="{{ asset($foto) }}" alt="{{ $variant->nama }}" class="h-48 w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="h-48 w-full bg-[#FFFFFF] flex items-center justify-center text-sm text-gray-500">Foto menyusul</div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <x-status-badge status="{{ $unitSiapVarian->isNotEmpty() ? 'Tersedia' : 'Dipesan' }}" />
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-1 justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-bold text-lg text-[#16181D] group-hover:text-[#C1121F] transition-colors">{{ $variant->nama }}</h3>
                                    @if ($tahunVarian)
                                        <span class="text-xs font-semibold text-[#4B5563] tabular-nums px-2 py-0.5 bg-[#FFFFFF] border border-[#E5E7EB] rounded-md">{{ $tahunVarian }}</span>
                                    @endif
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                    <span class="px-2.5 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#4B5563] font-medium">{{ $variant->transmisi }}</span>
                                    <span class="px-2.5 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#4B5563] font-medium">{{ $variant->bbm }}</span>
                                </div>
                                <div class="mt-4 pt-3 border-t border-[#E5E7EB] text-xs text-[#4B5563]">
                                    <span>Tersedia di: <strong class="text-[#16181D]">{{ $cabangVarian->isNotEmpty() ? $cabangVarian->join(' dan ') : '-' }}</strong></span>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-[#E5E7EB]">
                                <p class="text-[11px] text-[#4B5563] font-medium">Harga OTR{{ $cabangVarian->isNotEmpty() ? ' '.$cabangVarian->first() : '' }}</p>
                                <p class="mt-0.5 text-xl font-extrabold text-[#16181D] tabular-nums tracking-tight">
                                    {{ $mulai ? 'Rp '.number_format($mulai, 0, ',', '.') : 'Hubungi Cabang' }}
                                </p>
                                <div class="mt-5">
                                    <span class="w-full py-2.5 inline-flex items-center justify-center text-sm font-semibold text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] group-hover:text-white group-hover:bg-[#C1121F] group-hover:border-[#C1121F] rounded-xl transition-all duration-200 min-h-[44px]">
                                        Spesifikasi & SPK
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
