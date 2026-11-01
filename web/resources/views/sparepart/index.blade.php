<x-site-layout judul="Sparepart" deskripsi="Katalog suku cadang asli per cabang Ayoto Nippon.">
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
            </a>
            <a href="{{ route('katalog.index') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Katalog</a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Katalog Sparepart</h1>
        @if (session('sukses'))<p class="mt-3 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <form method="GET" class="mt-4 flex flex-col sm:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode" class="flex-1 rounded-lg border-gray-300 min-h-[44px]">
            <select name="cabang" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua cabang</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                @endforeach
            </select>
            <button class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Cari</button>
        </form>
        @if ($parts->isEmpty())
            <div class="mt-6 p-6 border border-gray-200 rounded-xl"><p class="font-semibold text-[#16181D]">Sparepart tidak ditemukan.</p><p class="text-sm text-[#4B5563]">Ubah kata kunci atau cabang.</p></div>
        @else
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($parts as $part)
                    <div class="p-5 border border-gray-200 rounded-xl">
                        <p class="text-xs text-[#4B5563]">{{ $part->branch->nama }}{{ $part->kode ? ' / '.$part->kode : '' }}</p>
                        <h2 class="mt-1 font-bold text-[#16181D]">{{ $part->nama }}</h2>
                        <p class="mt-1 font-semibold text-[#16181D] tabular-nums">Rp {{ number_format($part->harga, 0, ',', '.') }}</p>
                        <p class="text-sm {{ $part->stok > 0 ? 'text-[#16181D]' : 'text-[#C1121F]' }}">Stok: {{ $part->stok }}</p>
                        @if ($part->stok > 0)
                            <a href="{{ route('sparepart.order.checkout', $part) }}" class="mt-3 block text-center w-full px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Beli Sparepart Ini</a>
                        @else
                            <p class="mt-3 text-sm font-semibold text-[#C1121F]">Stok habis</p>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $parts->links() }}</div>
        @endif
    </div>
</x-site-layout>
