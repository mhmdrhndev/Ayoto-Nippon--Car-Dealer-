<x-site-layout>
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-[#4B5563] hover:underline min-h-[44px] inline-flex items-center">Kembali ke katalog</a>
        @php
            $semuaUnit = $m->variants->flatMap->units;
            $fotoUtama = $semuaUnit->where('status', 'Tersedia')->first()?->foto_utama ?? $semuaUnit->first()?->foto_utama;
            $adaStok = $semuaUnit->where('status', 'Tersedia')->isNotEmpty();
        @endphp
        <div class="mt-2 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @if ($fotoUtama)
                    <img src="{{ asset($fotoUtama) }}" alt="{{ $m->brand->nama }} {{ $m->nama }}" class="w-full aspect-video object-cover rounded-2xl">
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-2xl flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-[#4B5563]">{{ $m->brand->nama }}</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D]">{{ $m->nama }}</h1>
                <p class="mt-2"><x-status-badge status="{{ $adaStok ? 'Tersedia' : 'Dipesan' }}" /></p>
                @if ($kategori)
                    <p class="mt-3 flex gap-2 text-xs">
                        <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $kategori['body'] }}</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $kategori['kursi'] }} kursi</span>
                    </p>
                @elseif ($m->deskripsi)
                    <p class="mt-3 text-sm text-[#4B5563]">{{ $m->deskripsi }}</p>
                @endif
                @if ($mulai)
                    <p class="mt-3 text-lg font-bold text-[#16181D] tabular-nums">Mulai Rp {{ number_format($mulai, 0, ',', '.') }}</p>
                @endif
                <p class="mt-2 text-sm text-[#16181D]">{{ $ringkasan }}</p>
            </div>
        </div>

        <h2 class="mt-10 text-xl font-bold text-[#16181D]">Pilih Varian ({{ $m->variants->count() }})</h2>
        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($m->variants as $variant)
                @php
                    $foto = $variant->units->where('status', 'Tersedia')->first()?->foto_utama ?? $variant->units->first()?->foto_utama;
                    $mulai = $variant->priceLists->min('otr');
                @endphp
                <div class="border border-gray-200 rounded-2xl overflow-hidden flex flex-col">
                    @if ($foto)
                        <img src="{{ asset($foto) }}" alt="{{ $variant->nama }}" class="h-44 w-full object-cover" loading="lazy">
                    @else
                        <div class="h-44 w-full bg-gray-100 flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                    @endif
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-bold text-[#16181D]">{{ $variant->nama }}</h3>
                        <p class="mt-2 flex gap-2 text-xs">
                            <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->transmisi }}</span>
                            <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->bbm }}</span>
                        </p>
                        <p class="mt-3 text-lg font-bold text-[#16181D] tabular-nums">
                            {{ $mulai ? 'Mulai Rp '.number_format($mulai, 0, ',', '.') : 'Harga belum tersedia' }}
                        </p>
                        <a href="{{ route('katalog.show', $variant->slug) }}" class="mt-4 px-4 py-2 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
