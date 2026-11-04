<x-site-layout judul="Katalog Mobil" deskripsi="Katalog mobil baru dengan harga OTR per cabang dan stok nyata per varian di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <!-- Header & Top Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-end pb-6 border-b border-[#E5E7EB]">
            <div class="lg:col-span-2">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Showroom Digital</p>
                <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">Katalog Kendaraan Baru</h1>
                <p class="mt-2 text-sm text-[#4B5563] tabular-nums">
                    Tersedia <span class="text-[#16181D] font-semibold">{{ $models->total() }}</span> model dan <span class="text-[#16181D] font-semibold">{{ number_format($totalUnit, 0, ',', '.') }}</span> unit siap kirim di {{ $branches->count() }} cabang dealer resmi Ayoto Nippon.
                </p>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl px-3.5 py-3 text-center">
                    <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Ready Stock</p>
                    <p class="mt-1 text-lg sm:text-xl font-bold text-[#16181D] tabular-nums">{{ number_format($totalUnit, 0, ',', '.') }}</p>
                </div>
                <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl px-3.5 py-3 text-center">
                    <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Model</p>
                    <p class="mt-1 text-lg sm:text-xl font-bold text-[#16181D] tabular-nums">{{ $models->total() }}</p>
                </div>
                <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl px-3.5 py-3 text-center">
                    <p class="text-[10px] uppercase tracking-wider text-[#4B5563] font-medium">Cabang</p>
                    <p class="mt-1 text-lg sm:text-xl font-bold text-[#16181D] tabular-nums">{{ $branches->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4 shadow-lg shadow-black/5">
            <form action="{{ route('katalog.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-3">
                <div class="lg:col-span-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama model..." aria-label="Cari nama model"
                        class="w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3.5">
                </div>

                <div>
                    <select name="brand" aria-label="Merek" 
                        class="w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3">
                        <option value="">Semua Merek</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected(request('brand') === $brand->slug)>{{ $brand->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="transmisi" aria-label="Transmisi" 
                        class="w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3">
                        <option value="">Transmisi</option>
                        @foreach (['MT', 'AT', 'CVT'] as $t)
                            <option value="{{ $t }}" @selected(request('transmisi') === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="bbm" aria-label="BBM" 
                        class="w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3">
                        <option value="">Bahan Bakar</option>
                        @foreach ($bbms as $b)
                            <option value="{{ $b }}" @selected(request('bbm') === $b)>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="cabang" aria-label="Cabang" 
                        class="w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3">
                        <option value="">Semua Cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 font-semibold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[44px] transition-colors flex items-center justify-center">
                        Filter
                    </button>
                    <a href="{{ route('katalog.index') }}" class="px-3 py-2 text-xs font-semibold text-[#4B5563] hover:text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl min-h-[44px] inline-flex items-center justify-center transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @php
            $chipCabang = $branches->firstWhere('kode', request('cabang'))?->nama;
            $adaFilter = request('q') || request('brand') || request('transmisi') || request('bbm') || request('cabang');
        @endphp

        <!-- Results Header & Sort Control -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs sm:text-sm">
            <div class="flex flex-wrap items-center gap-2">
                <span class="font-bold text-[#16181D] tabular-nums">{{ $models->total() }}</span>
                <span class="text-[#4B5563]">model ditemukan</span>
                @if ($adaFilter)
                    <span class="text-gray-600">•</span>
                    <a href="{{ route('katalog.index') }}" class="font-semibold text-[#C1121F] hover:underline min-h-[44px] inline-flex items-center">Hapus Semua Filter</a>
                @endif
            </div>

            <form action="{{ route('katalog.index') }}" method="GET" class="flex items-center gap-2 text-[#4B5563]">
                @foreach (['q', 'brand', 'transmisi', 'bbm', 'cabang'] as $kunci)
                    @if (request($kunci))
                        <input type="hidden" name="{{ $kunci }}" value="{{ request($kunci) }}">
                    @endif
                @endforeach
                <label for="urut" class="text-xs">Urutkan:</label>
                <select id="urut" name="urut" onchange="this.form.submit()" 
                    class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-xs min-h-[40px] px-3 focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F]">
                    <option value="">Rekomendasi Dealer</option>
                    <option value="termurah" @selected(request('urut') === 'termurah')>Harga Termurah</option>
                    <option value="termahal" @selected(request('urut') === 'termahal')>Harga Termahal</option>
                </select>
            </form>
        </div>

        <!-- Models Catalog Grid -->
        @if ($models->isEmpty())
            <div class="p-12 border border-[#E5E7EB] bg-[#FFFFFF] rounded-3xl text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-[#FFFFFF] border border-[#E5E7EB] flex items-center justify-center mx-auto text-[#4B5563] mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-[#16181D]">Tidak Ada Unit Ditemukan</h3>
                <p class="mt-2 text-sm text-[#4B5563]">Coba ubah kata kunci pencarian atau sesuaikan pilihan filter.</p>
                <a href="{{ route('katalog.index') }}" class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[44px] transition-colors shadow-lg shadow-[#C1121F]/20">
                    Lihat Semua Katalog
                </a>
            </div>
        @else
            <div class="reveal grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($models as $model)
                    @php
                        $tersedia = $model->variants->flatMap->units->where('status', 'Tersedia');
                        $foto = $tersedia->first()?->foto_utama ?? $model->variants->flatMap->units->first()?->foto_utama;
                        $harga = $model->variants->flatMap(function ($v) use ($kodeCabang) {
                            return $kodeCabang ? $v->priceLists->where('branch.kode', $kodeCabang) : $v->priceLists;
                        })->min('otr');
                    @endphp
                    <a href="{{ route('katalog.model', [$model->brand->slug, $model->slug]) }}" 
                       class="group bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden flex flex-col transition-all duration-300 hover:border-[#C1121F] hover:shadow-2xl hover:shadow-black/5 hover:-translate-y-1 focus-visible:-translate-y-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">
                        <div class="relative bg-[#FFFFFF] overflow-hidden">
                            @if ($foto)
                                <img src="{{ asset($foto) }}" alt="{{ $model->brand->nama }} {{ $model->nama }}" class="h-52 w-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="h-52 w-full bg-[#FFFFFF] flex items-center justify-center text-sm text-gray-500">Foto menyusul</div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <x-status-badge status="{{ $tersedia->isNotEmpty() ? 'Tersedia' : 'Dipesan' }}" />
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-1 justify-between">
                            <div>
                                <p class="text-xs font-semibold text-[#4B5563] uppercase tracking-wider">{{ $model->brand->nama }}</p>
                                <h2 class="mt-1 text-xl font-bold text-[#16181D] group-hover:text-[#C1121F] transition-colors">{{ $model->nama }}</h2>
                                
                                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                                    <span class="px-2.5 py-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-lg text-[#4B5563] font-medium">{{ $model->variants->count() }} Varian</span>
                                    <span class="px-2.5 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-700 font-semibold tabular-nums">{{ $tersedia->count() }} unit siap kirim</span>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-[#E5E7EB]">
                                <p class="text-[11px] text-[#4B5563] font-medium">Harga OTR Mulai{{ $kodeCabang ? ' ('.$chipCabang.')' : '' }}</p>
                                <p class="mt-0.5 text-xl font-extrabold text-[#16181D] tabular-nums tracking-tight">
                                    {{ $harga ? 'Rp '.number_format($harga, 0, ',', '.') : 'Hubungi Cabang' }}
                                </p>

                                <div class="mt-4 pt-3 border-t border-[#E5E7EB] grid grid-cols-2 gap-2 text-xs text-[#4B5563]">
                                    <div>
                                        <span class="block text-[10px] uppercase tracking-wider text-gray-500">Transmisi</span>
                                        <strong class="text-[#16181D] mt-0.5 block truncate">{{ $model->variants->pluck('transmisi')->unique()->join(', ') }}</strong>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] uppercase tracking-wider text-gray-500">Bahan Bakar</span>
                                        <strong class="text-[#16181D] mt-0.5 block truncate">{{ $model->variants->pluck('bbm')->unique()->join(', ') }}</strong>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <span class="w-full py-2.5 inline-flex items-center justify-center text-sm font-semibold text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] group-hover:text-white group-hover:bg-[#C1121F] group-hover:border-[#C1121F] rounded-xl transition-all duration-200 min-h-[44px]">
                                        Pilih Varian
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-[#E5E7EB] text-[#4B5563]">
                {{ $models->links() }}
            </div>
        @endif
    </div>

    <x-site-footer />
</x-site-layout>
