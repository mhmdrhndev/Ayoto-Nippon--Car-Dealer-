<x-site-layout>
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-end">
            <div class="lg:col-span-2">
                <p class="inline-flex items-center text-xs font-semibold text-[#16181D] bg-gray-100 rounded-md px-3 py-1.5">UNIT RESMI DUA CABANG</p>
                <h1 class="mt-2 text-2xl sm:text-3xl font-bold text-[#16181D]">Katalog Mobil</h1>
                <p class="mt-1 text-sm text-[#4B5563] tabular-nums">{{ $models->total() }} model dan {{ number_format($totalUnit, 0, ',', '.') }} unit tersedia di jaringan dealer Ayoto Nippon.</p>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-center">
                    <p class="text-[11px] text-[#4B5563]">Unit ready stock</p>
                    <p class="text-lg font-bold text-[#16181D] tabular-nums">{{ number_format($totalUnit, 0, ',', '.') }}</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-center">
                    <p class="text-[11px] text-[#4B5563]">Model</p>
                    <p class="text-lg font-bold text-[#16181D] tabular-nums">{{ $models->total() }}</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-center">
                    <p class="text-[11px] text-[#4B5563]">Cabang</p>
                    <p class="text-lg font-bold text-[#16181D] tabular-nums">{{ $branches->count() }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('katalog.index') }}" method="GET" class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama model" aria-label="Cari nama model"
                class="rounded-lg border-gray-300 min-h-[44px]">
            <select name="brand" aria-label="Merek" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua merek</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->slug }}" @selected(request('brand') === $brand->slug)>{{ $brand->nama }}</option>
                @endforeach
            </select>
            <select name="transmisi" aria-label="Transmisi" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua transmisi</option>
                @foreach (['MT', 'AT', 'CVT'] as $t)
                    <option value="{{ $t }}" @selected(request('transmisi') === $t)>{{ $t }}</option>
                @endforeach
            </select>
            <select name="bbm" aria-label="BBM" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua BBM</option>
                @foreach ($bbms as $b)
                    <option value="{{ $b }}" @selected(request('bbm') === $b)>{{ $b }}</option>
                @endforeach
            </select>
            <select name="cabang" aria-label="Cabang" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua cabang</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                @endforeach
            </select>
            <div class="col-span-2 sm:col-span-1 flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Filter</button>
                <a href="{{ route('katalog.index') }}" class="px-4 py-2 text-sm font-medium text-[#16181D] border border-gray-300 rounded-lg min-h-[44px] inline-flex items-center">Reset</a>
            </div>
        </form>

        @php
            $chipMerek = $brands->firstWhere('slug', request('brand'))?->nama;
            $chipCabang = $branches->firstWhere('kode', request('cabang'))?->nama;
            $adaFilter = request('q') || request('brand') || request('transmisi') || request('bbm') || request('cabang');
        @endphp
        <div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex flex-wrap items-center gap-2 text-xs flex-1">
                <span class="font-semibold text-[#4B5563]">FILTER AKTIF:</span>
                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">Merek: {{ $chipMerek ?? 'Semua' }}</span>
                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">Transmisi: {{ request('transmisi') ?: 'Semua' }}</span>
                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">BBM: {{ request('bbm') ?: 'Semua' }}</span>
                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">Cabang: {{ $chipCabang ?? 'Semua cabang' }}</span>
                @if ($adaFilter)
                    <a href="{{ route('katalog.index') }}" class="font-semibold text-[#C1121F] hover:underline min-h-[44px] inline-flex items-center">Atur Ulang Semua</a>
                @endif
            </div>
            <form action="{{ route('katalog.index') }}" method="GET" class="flex items-center gap-2 text-xs text-[#4B5563]">
                @foreach (['q', 'brand', 'transmisi', 'bbm', 'cabang'] as $kunci)
                    @if (request($kunci))
                        <input type="hidden" name="{{ $kunci }}" value="{{ request($kunci) }}">
                    @endif
                @endforeach
                <label for="urut">Urutan Harga:</label>
                <select id="urut" name="urut" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-xs min-h-[44px]">
                    <option value="">Rekomendasi Dealer</option>
                    <option value="termurah" @selected(request('urut') === 'termurah')>Termurah</option>
                    <option value="termahal" @selected(request('urut') === 'termahal')>Termahal</option>
                </select>
            </form>
        </div>

        @if ($models->isEmpty())
            <div class="mt-8 p-6 border border-gray-200 rounded-xl">
                <p class="font-semibold text-[#16181D]">Tidak ada unit yang cocok dengan filter ini.</p>
                <p class="mt-1 text-sm text-[#4B5563]">Ubah filter atau lihat semua katalog.</p>
                <a href="{{ route('katalog.index') }}" class="mt-3 inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Lihat Semua Katalog</a>
            </div>
        @else
            <div class="reveal mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($models as $model)
                    @php
                        $tersedia = $model->variants->flatMap->units->where('status', 'Tersedia');
                        $foto = $tersedia->first()?->foto_utama ?? $model->variants->flatMap->units->first()?->foto_utama;
                        $harga = $model->variants->flatMap(function ($v) use ($kodeCabang) {
                            return $kodeCabang ? $v->priceLists->where('branch.kode', $kodeCabang) : $v->priceLists;
                        })->min('otr');
                    @endphp
                    <a href="{{ route('katalog.model', [$model->brand->slug, $model->slug]) }}" class="block border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-[#16181D] hover:shadow-lg hover:-translate-y-1 focus-visible:-translate-y-1">
                        <div class="relative">
                            @if ($foto)
                                <img src="{{ asset($foto) }}" alt="{{ $model->brand->nama }} {{ $model->nama }}" class="h-48 w-full object-cover" loading="lazy">
                            @else
                                <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                            @endif
                            <span class="absolute top-3 left-3"><x-status-badge status="{{ $tersedia->isNotEmpty() ? 'Tersedia' : 'Dipesan' }}" /></span>
                        </div>
                        <div class="p-5">
                            <p class="text-xs font-medium text-[#4B5563]">{{ $model->brand->nama }}</p>
                            <h2 class="mt-1 text-lg font-bold text-[#16181D]">{{ $model->nama }}</h2>
                            <p class="mt-2 flex gap-2 text-xs">
                                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $model->variants->count() }} Varian</span>
                                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D] tabular-nums">{{ $tersedia->count() }} unit ready</span>
                            </p>
                            <p class="mt-1 text-xs text-[#4B5563]">Harga Mulai (OTR{{ $kodeCabang ? ' '.$chipCabang : '' }})</p>
                            <p class="text-lg font-bold text-[#16181D] tabular-nums">
                                {{ $harga ? 'Mulai Rp '.number_format($harga, 0, ',', '.') : 'Harga belum tersedia' }}
                            </p>
                            <p class="mt-2 flex gap-4 text-xs text-[#4B5563] border-t border-gray-100 pt-3">
                                <span>Transmisi<br><strong class="text-[#16181D]">{{ $model->variants->pluck('transmisi')->unique()->join(', ') }}</strong></span>
                                <span>BBM<br><strong class="text-[#16181D]">{{ $model->variants->pluck('bbm')->unique()->join(', ') }}</strong></span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">{{ $models->links() }}</div>
        @endif
    </div>

    <x-site-footer />
</x-site-layout>
