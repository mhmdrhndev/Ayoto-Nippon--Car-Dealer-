<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-6 w-full sm:px-6 lg:px-8 space-y-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @hasanyrole('sales|admin-cabang|pimpinan|superadmin|owner')
                <a href="{{ route('admin.verify.index') }}" class="block bg-surface p-5 rounded-xl border border-line border-l-4 border-l-accent shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">
                    <p class="text-sm font-medium text-muted">SPK menunggu verifikasi</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $spkMenunggu }}</p>
                </a>
                <a href="{{ route('admin.leads.index') }}" class="block bg-surface p-5 rounded-xl border border-line border-l-4 border-l-ink shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    <p class="text-sm font-medium text-muted">Leads baru</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $leadsBaru }}</p>
                </a>
            @endhasanyrole
            @hasanyrole('service-advisor|mekanik|admin-cabang|pimpinan|superadmin|owner')
                <a href="{{ route('admin.services.index') }}" class="block bg-surface p-5 rounded-xl border border-line border-l-4 border-l-ink shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    <p class="text-sm font-medium text-muted">Servis aktif</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $servisAktif }}</p>
                </a>
            @endhasanyrole
            <div class="bg-surface p-5 rounded-xl border border-line shadow-sm">
                <p class="text-sm font-medium text-muted">Unit tersedia</p>
                <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $unitTersedia }}</p>
            </div>
            @if (isset($leadsSaya))
                <div class="bg-surface p-5 rounded-xl border border-line shadow-sm">
                    <p class="text-sm font-medium text-muted">Leads saya</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $leadsSaya }}</p>
                    <p class="mt-1 text-xs text-muted">{{ $followupJatuh }} jatuh tempo</p>
                </div>
            @endif
            @if (isset($tugasSaya))
                <div class="bg-surface p-5 rounded-xl border border-line shadow-sm">
                    <p class="text-sm font-medium text-muted">Servis tugas saya</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $tugasSaya }}</p>
                </div>
            @endif
            @if (isset($spkSaya))
                <a href="{{ route('pesanan.index') }}" class="block bg-surface p-5 rounded-xl border border-line shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ink">
                    <p class="text-sm font-medium text-muted">SPK saya</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-ink">{{ $spkSaya }}</p>
                    <p class="mt-1 text-xs font-semibold text-accent">Lihat pesanan saya</p>
                </a>
            @endif
        </div>

        @if (isset($antreanSpk))
            <section aria-labelledby="antrean-judul" class="bg-surface rounded-xl border border-line shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-line flex items-center justify-between gap-3">
                    <div>
                        <h3 id="antrean-judul" class="font-bold text-ink">Perlu verifikasi</h3>
                        <p class="text-xs text-muted">SPK tertua menunggu keputusan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-red-50 dark:bg-red-500/10 text-accent text-xs font-semibold px-2.5 py-0.5">{{ $antreanSpk->count() }} antrean</span>
                        <a href="{{ route('admin.verify.index') }}" class="text-sm font-semibold text-accent hover:underline min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Semua</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-line text-left">
                            <th scope="col" class="px-4 py-2.5 font-semibold text-ink">No. SPK</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold text-ink">Pelanggan</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold text-ink text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antreanSpk as $order)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3 font-mono text-ink">{{ $order->no_spk }}</td>
                                <td class="px-4 py-3">{{ $order->customer->nama }}<br><span class="text-muted">{{ $order->branch->nama }}</span></td>
                                <td class="px-4 py-3 text-right"><a href="{{ route('admin.verify.index') }}" class="underline font-medium text-accent min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Verifikasi</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-sm text-muted">Tidak ada SPK menunggu verifikasi. <a href="{{ route('admin.verify.index') }}" class="font-semibold text-accent underline">Buka verifikasi</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </section>
        @endif

        @if (isset($followups))
            <section aria-labelledby="followup-judul" class="bg-surface rounded-xl border border-line shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-line flex items-center justify-between gap-3">
                    <div>
                        <h3 id="followup-judul" class="font-bold text-ink">Follow-up jatuh tempo</h3>
                        <p class="text-xs text-muted">Leads yang perlu dihubungi.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-surface-2 text-ink text-xs font-semibold px-2.5 py-0.5">{{ $followups->count() }} leads</span>
                        <a href="{{ route('admin.leads.index') }}" class="text-sm font-semibold text-accent hover:underline min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Semua</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-line text-left">
                            <th scope="col" class="px-4 py-2.5 font-semibold text-ink">Leads</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold text-ink text-right">Jatuh tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($followups as $lead)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3"><a href="{{ route('admin.leads.show', $lead) }}" class="underline font-medium text-ink min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ink">#{{ $lead->id }} {{ $lead->customer->nama ?? '' }}</a></td>
                                <td class="px-4 py-3 text-right text-muted">{{ $lead->followup_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-sm text-muted">Tidak ada follow-up jatuh tempo. <a href="{{ route('admin.leads.index') }}" class="font-semibold text-accent underline">Buka leads</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </section>
        @endif

        @hasanyrole('owner|pimpinan|superadmin')
            @if (isset($grafikOmzet))
                <div class="bg-surface p-5 rounded-xl border border-line shadow-sm" x-data="{ level: 'tahun', tahun: '' }">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-bold text-ink" x-text="level === 'tahun' ? 'Omzet per tahun' : 'Omzet ' + tahun + ' per bulan'"></h3>
                            <p class="text-xs text-muted">Klik titik tahun untuk rincian bulan.</p>
                        </div>
                        <button type="button" x-show="level === 'bulan'" @click="level = 'tahun'" class="text-xs font-semibold text-accent hover:underline min-h-[44px] inline-flex items-center rounded px-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent">Kembali ke tahun</button>
                    </div>
                    @if (array_sum(array_column($grafikOmzet['tahun']['items'], 'nominal')) === 0)
                        <p class="mt-2 text-sm text-muted">Belum ada penjualan Deal pada periode ini.</p>
                    @else
                        <div x-show="level === 'tahun'">
                            <x-grafik-garis :items="$grafikOmzet['tahun']['items']" :skala="$grafikOmzet['tahun']['skala']" :klik="true" />
                        </div>
                        @foreach ($grafikOmzet['bulanan'] as $tahun => $data)
                            <div x-show="level === 'bulan' && tahun === '{{ $tahun }}'" x-cloak>
                                <x-grafik-garis :items="$data['items']" :skala="$data['skala']" />
                            </div>
                        @endforeach
                        <p class="mt-1 text-xs text-muted">Klik titik tahun untuk rincian bulan.</p>
                    @endif
                </div>
            @endif
        @endhasanyrole
    </div>
</x-app-layout>
