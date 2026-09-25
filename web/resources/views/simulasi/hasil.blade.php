<x-site-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
            </a>
            <a href="{{ route('katalog.index') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Katalog</a>
        </div>
    </div>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Hasil Simulasi</h1>
        <div class="mt-4 p-5 border border-gray-200 rounded-xl">
            <p class="text-sm text-[#4B5563]">{{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }} via {{ $leasing->nama }}</p>
            <p class="mt-1 text-sm text-[#16181D]">Harga OTR: <span class="font-semibold tabular-nums">Rp {{ number_format($otr, 0, ',', '.') }}</span></p>
            <p class="mt-3 text-sm text-[#4B5563]">Estimasi angsuran</p>
            <p class="text-3xl font-bold text-[#16181D] tabular-nums">Rp {{ number_format($angsuran, 0, ',', '.') }}<span class="text-base font-medium">/bulan x {{ $tenor }}</span></p>
            <p class="mt-2 text-xs text-[#4B5563]">Estimasi kasar dengan bunga flat {{ $leasing->bunga_dasar }}% per tahun. Angka final mengikuti persetujuan leasing.</p>
        </div>
        <p class="mt-3 text-sm text-[#4B5563]">Hasil ini sudah tersimpan. Sales kami akan menghubungi Anda.</p>
        <div class="mt-4 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('spk.create', ['variant_id' => $variant->id]) }}" class="px-6 py-3 text-center font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Ajukan SPK</a>
            <a href="{{ route('simulasi.form') }}" class="px-6 py-3 text-center font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px]">Hitung Ulang</a>
        </div>
    </div>
</x-site-layout>
