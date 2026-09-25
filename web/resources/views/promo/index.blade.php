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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Promo Berjalan</h1>
        <form method="GET" class="mt-4 flex gap-3">
            <select name="cabang" class="rounded-lg border-gray-300 min-h-[44px]">
                <option value="">Semua cabang</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                @endforeach
            </select>
            <button class="px-6 py-2 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Filter</button>
        </form>
        @if ($promos->isEmpty())
            <div class="mt-6 p-6 border border-gray-200 rounded-xl"><p class="font-semibold text-[#16181D]">Belum ada promo berjalan.</p><p class="text-sm text-[#4B5563]">Kembali lagi nanti atau lihat katalog mobil.</p></div>
        @else
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($promos as $promo)
                    <div class="p-5 border border-gray-200 rounded-xl">
                        <h2 class="font-bold text-[#16181D]">{{ $promo->judul }}</h2>
                        <p class="text-xs text-[#4B5563]">{{ $promo->branch->nama ?? 'Semua cabang' }}, sampai {{ $promo->selesai->format('d M Y') }}</p>
                        @if ($promo->deskripsi)<p class="mt-2 text-sm text-[#16181D]">{{ $promo->deskripsi }}</p>@endif
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $promos->links() }}</div>
        @endif
    </div>
</x-site-layout>
