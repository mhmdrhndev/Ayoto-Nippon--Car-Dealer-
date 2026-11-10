<x-site-layout judul="Promo Berjalan" deskripsi="Program promo resmi dan penawaran kredit mobil baru di dealer Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <div class="pb-6 border-b border-line">
            <p class="text-xs font-semibold tracking-wider text-accent uppercase">Program Resmi Dealer</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-ink tracking-tight">Promo & Penawaran Berjalan</h1>
            <p class="mt-2 text-sm text-muted">
                Paket uang muka rendah, subsidi bunga pembiayaan, dan bonus suku cadang per cabang resmi Ayoto Nippon.
            </p>
        </div>

        <div class="bg-surface border border-line rounded-2xl p-4 shadow-lg max-w-md">
            <form method="GET" class="flex gap-3">
                <select name="cabang" 
                    class="flex-1 bg-surface border border-line rounded-xl text-ink text-sm focus:border-accent focus:ring-1 focus:ring-accent min-h-[44px] px-3.5">
                    <option value="">Semua Cabang Dealer</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->kode }}" @selected(request('cabang') === $branch->kode)>{{ $branch->nama }}</option>
                    @endforeach
                </select>
                <button class="px-5 py-2.5 font-bold text-sm text-white bg-accent-strong hover:bg-[#9E0E19] rounded-xl min-h-[44px] transition-colors flex items-center justify-center">
                    Filter
                </button>
            </form>
        </div>

        @if ($promos->isEmpty())
            <div class="p-12 border border-line bg-surface rounded-3xl text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-surface border border-line flex items-center justify-center mx-auto text-muted mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                </div>
                <h3 class="text-lg font-bold text-ink">Belum Ada Promo Aktif</h3>
                <p class="mt-2 text-sm text-muted">Silakan periksa kembali cabang lain atau lihat katalog kendaraan kami.</p>
                <a href="{{ route('katalog.index') }}" class="mt-6 inline-flex items-center px-5 py-2.5 text-xs font-bold text-white bg-accent-strong rounded-xl">
                    Buka Katalog Mobil
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($promos as $promo)
                    <div id="promo-{{ $promo->id }}" class="bg-surface border border-line rounded-3xl overflow-hidden shadow-xl hover:border-accent transition-all flex flex-col justify-between scroll-mt-24 group">
                        @if ($promo->banner)
                            <div class="relative w-full h-52 bg-surface overflow-hidden">
                                <img src="{{ asset($promo->banner) }}" alt="{{ $promo->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-surface via-transparent to-transparent"></div>
                            </div>
                        @endif
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-accent-strong/15 border border-accent/25 text-accent mb-2.5">
                                    {{ $promo->branch->nama ?? 'Semua Cabang' }}
                                </span>
                                <h2 class="font-bold text-xl text-ink group-hover:text-accent transition-colors">{{ $promo->judul }}</h2>
                                <p class="text-xs text-muted mt-1">Berlaku hingga {{ $promo->selesai->format('d M Y') }}</p>
                                @if ($promo->deskripsi)
                                    <p class="mt-3 text-sm text-muted leading-relaxed">{{ $promo->deskripsi }}</p>
                                @endif
                            </div>
                            <div class="mt-6 pt-4 border-t border-line">
                                <a href="{{ route('katalog.index') }}" class="w-full py-2.5 px-4 text-center font-bold text-xs text-ink bg-surface border border-line group-hover:text-white group-hover:bg-accent-strong group-hover:border-accent rounded-xl transition-all min-h-[44px] flex items-center justify-center">
                                    Lihat Unit Mobil Promo &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-6 border-t border-line">
                {{ $promos->links() }}
            </div>
        @endif
    </div>

    <x-site-footer />
</x-site-layout>
