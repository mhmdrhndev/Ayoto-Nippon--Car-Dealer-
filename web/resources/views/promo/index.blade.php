<x-site-layout judul="Promo Berjalan" deskripsi="Program promo resmi dan penawaran kredit mobil baru di dealer Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <div class="pb-6 border-b border-[#E5E7EB]">
            <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Program Resmi Dealer</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">Promo & Penawaran Berjalan</h1>
            <p class="mt-2 text-sm text-[#4B5563]">
                Paket uang muka rendah, subsidi bunga pembiayaan, dan bonus suku cadang per cabang resmi Ayoto Nippon.
            </p>
        </div>

        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4 shadow-lg max-w-md">
            <form method="GET" class="flex gap-3">
                <select name="cabang" 
                    class="flex-1 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3.5">
                    <option value="">Semua Cabang Dealer</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
                <button class="px-5 py-2.5 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[44px] transition-colors flex items-center justify-center">
                    Filter
                </button>
            </form>
        </div>

        @if ($promos->isEmpty())
            <div class="p-12 border border-[#E5E7EB] bg-[#FFFFFF] rounded-3xl text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-[#FFFFFF] border border-[#E5E7EB] flex items-center justify-center mx-auto text-[#4B5563] mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                </div>
                <h3 class="text-lg font-bold text-[#16181D]">Belum Ada Promo Aktif</h3>
                <p class="mt-2 text-sm text-[#4B5563]">Silakan periksa kembali cabang lain atau lihat katalog kendaraan kami.</p>
                <a href="{{ route('katalog.index') }}" class="mt-6 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-[#C1121F] rounded-xl">
                    Buka Katalog Mobil
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($promos as $promo)
                    <div id="promo-{{ $promo->id }}" class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl overflow-hidden shadow-xl hover:border-[#C1121F] transition-all flex flex-col justify-between scroll-mt-24 group">
                        @if ($promo->banner)
                            <div class="relative w-full h-52 bg-[#FFFFFF] overflow-hidden">
                                <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#FFFFFF] via-transparent to-transparent"></div>
                            </div>
                        @endif
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[#C1121F]/15 border border-[#C1121F]/25 text-[#C1121F] mb-2.5">
                                    {{ $promo->branch->nama ?? 'Semua Cabang' }}
                                </span>
                                <h2 class="font-bold text-xl text-[#16181D] group-hover:text-[#C1121F] transition-colors">{{ $promo->judul }}</h2>
                                <p class="text-xs text-[#4B5563] mt-1">Berlaku hingga {{ $promo->selesai->format('d M Y') }}</p>
                                @if ($promo->deskripsi)
                                    <p class="mt-3 text-sm text-[#4B5563] leading-relaxed">{{ $promo->deskripsi }}</p>
                                @endif
                            </div>
                            <div class="mt-6 pt-4 border-t border-[#E5E7EB]">
                                <a href="{{ route('katalog.index') }}" class="w-full py-2.5 px-4 text-center font-bold text-xs text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] group-hover:text-white group-hover:bg-[#C1121F] group-hover:border-[#C1121F] rounded-xl transition-all min-h-[44px] flex items-center justify-center">
                                    Lihat Unit Mobil Promo &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-6 border-t border-[#E5E7EB]">
                {{ $promos->links() }}
            </div>
        @endif
    </div>

    <x-site-footer />
</x-site-layout>
