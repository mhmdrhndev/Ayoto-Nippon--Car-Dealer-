<x-site-layout judul="Cabang Kami" deskripsi="Jaringan showroom dan bengkel resmi dealer Ayoto Nippon di Jakarta dan Bandung.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <div class="pb-6 border-b border-line">
            <p class="text-xs font-semibold tracking-wider text-accent uppercase">Jaringan Dealer Resmi</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-ink tracking-tight">Lokasi Cabang Showroom & Bengkel</h1>
            <p class="mt-2 text-sm text-muted">
                Kunjungi fasilitas 3S (Sales, Service, Sparepart) resmi kami di wilayah Jakarta dan Bandung untuk layanan tatap muka langsung.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($branches as $branch)
                <div class="bg-surface border border-line rounded-3xl p-6 sm:p-8 flex flex-col justify-between hover:border-accent shadow-xl transition-all">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-line">
                            <span class="text-xs font-bold uppercase tracking-wider text-accent">Dealer Resmi 3S</span>
                            <span class="text-xs text-emerald-700 dark:text-emerald-300 font-semibold flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                Buka
                            </span>
                        </div>

                        <h2 class="mt-4 font-bold text-2xl text-ink">{{ $branch->nama }}</h2>
                        
                        <div class="mt-4 space-y-3 text-sm text-muted">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-muted shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $branch->alamat }}</span>
                            </div>

                            @if ($branch->telp)
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span class="font-mono text-ink">{{ $branch->telp }}</span>
                                </div>
                            @endif

                            @if ($branch->jam_operasional)
                                <div class="flex items-center gap-3 text-xs text-muted">
                                    <svg class="w-5 h-5 text-muted shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/><path d="M12 7v5l3 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span>Jam Kerja: {{ $branch->jam_operasional }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-line flex flex-wrap items-center justify-between gap-3">
                        @if ($branch->maps_url)
                            <a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" 
                                class="px-5 py-2.5 font-bold text-xs text-ink bg-surface border border-line hover:border-accent hover:text-accent rounded-xl min-h-[44px] inline-flex items-center gap-2 transition-colors">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Petunjuk Google Maps</span>
                            </a>
                        @endif

                        @if ($branch->telp)
                            <a href="{{ \App\Support\Wa::chat($branch->telp, 'Halo '.$branch->nama.', saya ingin informasi dealer.') }}" target="_blank" rel="noopener"
                                class="px-5 py-2.5 font-bold text-xs text-white bg-emerald-600 hover:bg-emerald-50 dark:bg-emerald-500/100 rounded-xl min-h-[44px] inline-flex items-center gap-1.5 transition-colors">
                                <span>Hubungi Cabang</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
