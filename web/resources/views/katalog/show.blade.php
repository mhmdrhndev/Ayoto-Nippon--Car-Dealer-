<x-site-layout>
    <x-site-header />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a href="{{ route('katalog.index') }}" class="text-sm font-medium text-[#4B5563] hover:underline min-h-[44px] inline-flex items-center">Kembali ke katalog</a>
        @php $unitSpk = $variant->units->where('status', 'Tersedia')->first(); @endphp
        <div class="mt-2 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @php $galeri = $variant->units->pluck('foto_utama')->filter()->unique()->values(); @endphp
                @if ($galeri->isNotEmpty())
                    <img src="{{ asset($galeri[0]) }}" alt="{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }}" class="w-full aspect-video object-cover rounded-2xl">
                    @if ($galeri->count() > 1)
                        <div class="mt-2 grid grid-cols-3 gap-2">
                            @foreach ($galeri->slice(1, 3) as $foto)
                                <img src="{{ asset($foto) }}" alt="" loading="lazy" class="w-full aspect-video object-cover rounded-xl">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-2xl flex items-center justify-center text-sm text-[#4B5563]">Foto menyusul</div>
                @endif
                <p class="mt-2 text-xs text-[#4B5563]">Warna dan detail mengikuti unit sebenarnya di cabang.</p>
            </div>
            <div>
                <p class="text-sm font-medium text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }}</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-bold text-[#16181D]">{{ $variant->nama }}</h1>
                <p class="mt-2 flex gap-2 text-xs">
                    <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->transmisi }}</span>
                    <span class="px-2 py-1 bg-gray-100 rounded-md text-[#16181D]">{{ $variant->bbm }}</span>
                </p>
                <h2 class="mt-6 text-lg font-bold text-[#16181D]">Spesifikasi</h2>
                @foreach ($variant->spekLengkap() as $grup => $baris)
                    <h3 class="mt-4 text-sm font-bold text-[#16181D]">{{ $grup }}</h3>
                    <dl class="mt-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                        @foreach ($baris as $label => $nilai)
                            <div class="flex justify-between gap-4 border-b border-gray-100 py-2">
                                <dt class="text-sm text-[#4B5563]">{{ $label }}</dt>
                                <dd class="text-sm font-semibold text-right text-[#16181D]">{{ $nilai }}</dd>
                            </div>
                        @endforeach
                    </dl>
                @endforeach
                <p class="mt-3 text-xs text-[#4B5563]">Angka di atas acuan katalog. Minta brosur resmi ke sales untuk angka pasti sebelum SPK.</p>
                <div class="mt-6 hidden lg:flex gap-3">
                    @auth
                        <a href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" class="flex-1 px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
                    @else
                        <a href="{{ route('register') }}" class="flex-1 px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Daftar untuk Ajukan SPK</a>
                    @endauth
                    <a href="{{ route('simulasi.form') }}" class="px-6 py-3 text-center font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Simulasi Kredit</a>
                </div>
            </div>
        </div>

        <h2 class="mt-8 text-lg font-bold text-[#16181D]">Harga OTR dan stok per cabang</h2>
        <div class="mt-2 overflow-x-auto border border-gray-200 rounded-xl">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left font-semibold text-[#16181D] px-4 py-3">Cabang</th>
                        <th class="text-left font-semibold text-[#16181D] px-4 py-3">Warna tersedia</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Harga OTR</th>
                        <th class="text-right font-semibold text-[#16181D] px-4 py-3">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variant->priceLists as $price)
                        <tr class="border-b border-gray-100 last:border-0">
                            <td class="px-4 py-3 text-[#16181D]">{{ $price->branch->nama }}</td>
                            <td class="px-4 py-3 text-[#16181D]">{{ ($warnaPerCabang[$price->branch_id] ?? collect())->join(', ') ?: 'Stok kosong' }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-[#16181D] tabular-nums">Rp {{ number_format($price->otr, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right"><x-status-badge status="{{ ($stok[$price->branch_id] ?? 0) > 0 ? 'Tersedia' : 'Dipesan' }}" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="lg:hidden sticky bottom-0 bg-white border-t border-gray-200 p-3 flex gap-2">
        @auth
            <a href="{{ $unitSpk ? route('spk.create', ['unit_id' => $unitSpk->id]) : route('spk.create') }}" class="flex-1 px-4 py-3 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
        @else
            <a href="{{ route('register') }}" class="flex-1 px-4 py-3 text-center text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Daftar untuk Ajukan SPK</a>
        @endauth
        <a href="{{ route('simulasi.form') }}" class="px-4 py-3 text-center text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Simulasi</a>
    </div>

    <x-site-footer />
</x-site-layout>
