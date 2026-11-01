<x-site-layout judul="Promo Berjalan" deskripsi="Promo mobil baru yang sedang berjalan di cabang Ayoto Nippon.">
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
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($promos as $promo)
                    <div id="promo-{{ $promo->id }}" class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-shadow flex flex-col scroll-mt-20">
                        @if ($promo->banner)
                            <div class="relative w-full h-48 bg-gray-100 overflow-hidden">
                                <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="font-bold text-lg text-[#16181D]">{{ $promo->judul }}</h2>
                                <p class="text-xs text-[#4B5563] mt-1">{{ $promo->branch->nama ?? 'Semua cabang' }} • Berlaku s.d {{ $promo->selesai->format('d M Y') }}</p>
                                @if ($promo->deskripsi)<p class="mt-2.5 text-sm text-gray-700 leading-relaxed">{{ $promo->deskripsi }}</p>@endif
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('katalog.index') }}" class="text-xs font-semibold text-[#C1121F] hover:underline inline-flex items-center gap-1 min-h-[44px]">
                                    Lihat Mobil Promo &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $promos->links() }}</div>
        @endif
    </div>
</x-site-layout>
