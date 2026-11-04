<x-site-layout judul="Katalog Sparepart Asli" deskripsi="Katalog suku cadang asli bergaransi resmi per cabang dealer Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <div class="pb-6 border-b border-[#E5E7EB]">
            <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Suku Cadang Resmi Pabrikan</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">Katalog Suku Cadang Asli</h1>
            <p class="mt-2 text-sm text-[#4B5563]">
                Jaminan keaslian suku cadang dengan nomor part resmi dan ketersediaan langsung di gudang cabang dealer kami.
            </p>
        </div>

        @if (session('sukses'))
            <div class="p-4 text-sm font-medium text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl p-4 shadow-lg">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama part atau kode nomor suku cadang..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px]">
                </div>

                <select name="cabang" 
                    class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[44px] px-3.5">
                    <option value="">Semua Cabang Gudang</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                    @endforeach
                </select>

                <button class="px-6 py-2.5 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[44px] transition-colors flex items-center justify-center">
                    Cari Suku Cadang
                </button>
            </form>
        </div>

        @if ($parts->isEmpty())
            <div class="p-12 border border-[#E5E7EB] bg-[#FFFFFF] rounded-3xl text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-[#FFFFFF] border border-[#E5E7EB] flex items-center justify-center mx-auto text-[#4B5563] mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-[#16181D]">Suku Cadang Tidak Ditemukan</h3>
                <p class="mt-2 text-sm text-[#4B5563]">Silakan ubah kata kunci pencarian atau pilih cabang dealer lainnya.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($parts as $part)
                    <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 flex flex-col justify-between hover:border-[#C1121F] transition-all shadow-xl">
                        <div>
                            <div class="flex items-center justify-between gap-2 text-xs text-[#4B5563] pb-3 border-b border-[#E5E7EB]">
                                <span>{{ $part->branch->nama }}</span>
                                @if ($part->kode)
                                    <span class="font-mono text-gray-500 text-[11px]">{{ $part->kode }}</span>
                                @endif
                            </div>
                            <h2 class="mt-3 font-bold text-lg text-[#16181D] line-clamp-2">{{ $part->nama }}</h2>
                            <p class="mt-4 text-2xl font-black text-[#16181D] tabular-nums tracking-tight">
                                Rp {{ number_format($part->harga, 0, ',', '.') }}
                            </p>
                            <div class="mt-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $part->stok > 0 ? 'bg-emerald-400' : 'bg-rose-500' }}"></span>
                                <span class="text-xs font-semibold {{ $part->stok > 0 ? 'text-[#4B5563]' : 'text-[#C1121F]' }}">
                                    {{ $part->stok > 0 ? 'Tersedia: '.$part->stok.' unit' : 'Stok habis' }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#E5E7EB]">
                            @if ($part->stok > 0)
                                <a href="{{ route('sparepart.order.checkout', $part) }}" 
                                    class="w-full py-3 px-4 text-center font-bold text-xs text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[44px] flex items-center justify-center transition-all shadow-lg shadow-[#C1121F]/20">
                                    Pesan Suku Cadang Ini
                                </a>
                            @else
                                <span class="w-full py-3 px-4 text-center font-bold text-xs text-gray-500 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl min-h-[44px] flex items-center justify-center cursor-not-allowed">
                                    Stok Belum Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-6 border-t border-[#E5E7EB]">
                {{ $parts->links() }}
            </div>
        @endif
    </div>

    <x-site-footer />
</x-site-layout>
