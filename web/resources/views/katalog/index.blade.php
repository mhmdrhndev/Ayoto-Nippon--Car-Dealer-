<x-site-layout>
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#16181D]">Katalog Mobil</h1>
        <p class="mt-1 text-sm text-[#4B5563]">{{ $models->total() }} model, {{ $totalUnit }} unit tersedia.</p>

        <form action="{{ route('katalog.index') }}" method="GET" class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama" aria-label="Cari nama"
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

        @if ($models->isEmpty())
            <div class="mt-8 p-6 border border-gray-200 rounded-xl">
                <p class="font-semibold text-[#16181D]">Tidak ada unit yang cocok dengan filter ini.</p>
                <p class="mt-1 text-sm text-[#4B5563]">Ubah filter atau lihat semua katalog.</p>
                <a href="{{ route('katalog.index') }}" class="mt-3 inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Lihat Semua Katalog</a>
            </div>
        @else
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($models as $model)
                    @php
                        $tersedia = $model->variants->flatMap->units->where('status', 'Tersedia');
                        $foto = $tersedia->first()?->foto_utama ?? $model->variants->flatMap->units->first()?->foto_utama;
                        $harga = $model->variants->flatMap(function ($v) use ($kodeCabang) {
                            return $kodeCabang ? $v->priceLists->where('branch.kode', $kodeCabang) : $v->priceLists;
                        })->min('otr');
                    @endphp
                    <a href="{{ route('katalog.model', [$model->brand->slug, $model->slug]) }}" class="block border border-gray-200 rounded-2xl overflow-hidden hover:border-[#16181D] hover:shadow-md">
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
                                <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $tersedia->count() }} unit</span>
                            </p>
                            <p class="mt-3 text-lg font-bold text-[#16181D] tabular-nums">
                                {{ $harga ? 'Mulai Rp '.number_format($harga, 0, ',', '.') : 'Harga belum tersedia' }}
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
