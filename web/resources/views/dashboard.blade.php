<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @hasanyrole('sales|admin-cabang|pimpinan|superadmin|owner')
                <a href="{{ route('admin.verify.index') }}" class="block bg-white p-5 rounded-xl border border-gray-200 border-l-4 border-l-[#C1121F] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">
                    <p class="text-sm font-medium text-gray-500">SPK menunggu verifikasi</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $spkMenunggu }}</p>
                </a>
                <a href="{{ route('admin.leads.index') }}" class="block bg-white p-5 rounded-xl border border-gray-200 border-l-4 border-l-[#16181D] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16181D]">
                    <p class="text-sm font-medium text-gray-500">Leads baru</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $leadsBaru }}</p>
                </a>
            @endhasanyrole
            @hasanyrole('service-advisor|mekanik|admin-cabang|pimpinan|superadmin|owner')
                <a href="{{ route('admin.services.index') }}" class="block bg-white p-5 rounded-xl border border-gray-200 border-l-4 border-l-[#16181D] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16181D]">
                    <p class="text-sm font-medium text-gray-500">Servis aktif</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $servisAktif }}</p>
                </a>
            @endhasanyrole
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Unit tersedia</p>
                <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $unitTersedia }}</p>
            </div>
            @if (isset($leadsSaya))
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Leads saya</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $leadsSaya }}</p>
                    <p class="mt-1 text-xs text-gray-500">{{ $followupJatuh }} jatuh tempo</p>
                </div>
            @endif
            @if (isset($tugasSaya))
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Servis tugas saya</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $tugasSaya }}</p>
                </div>
            @endif
            @if (isset($spkSaya))
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">SPK saya</p>
                    <p class="mt-1 text-2xl font-bold tabular-nums text-[#16181D]">{{ $spkSaya }}</p>
                </div>
            @endif
        </div>

        @if (isset($antreanSpk))
            <section aria-labelledby="antrean-judul" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between gap-3">
                    <div>
                        <h3 id="antrean-judul" class="font-bold text-[#16181D]">Perlu verifikasi</h3>
                        <p class="text-xs text-gray-500">SPK tertua menunggu keputusan.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-red-50 text-[#C1121F] text-xs font-semibold px-2.5 py-0.5">{{ $antreanSpk->count() }} antrean</span>
                        <a href="{{ route('admin.verify.index') }}" class="text-sm font-semibold text-[#C1121F] hover:underline min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">Semua</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left">
                            <th scope="col" class="px-4 py-2.5 font-semibold text-[#16181D]">No. SPK</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold text-[#16181D]">Pelanggan</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold text-[#16181D] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antreanSpk as $order)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3 font-mono text-[#16181D]">{{ $order->no_spk }}</td>
                                <td class="px-4 py-3">{{ $order->customer->nama }}<br><span class="text-gray-500">{{ $order->branch->nama }}</span></td>
                                <td class="px-4 py-3 text-right"><a href="{{ route('admin.verify.index') }}" class="underline font-medium text-[#C1121F] min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">Verifikasi</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada SPK menunggu verifikasi. <a href="{{ route('admin.verify.index') }}" class="font-semibold text-[#C1121F] underline">Buka verifikasi</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </section>
        @endif

        @if (isset($followups))
            <section aria-labelledby="followup-judul" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between gap-3">
                    <div>
                        <h3 id="followup-judul" class="font-bold text-[#16181D]">Follow-up jatuh tempo</h3>
                        <p class="text-xs text-gray-500">Leads yang perlu dihubungi.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-gray-100 text-[#16181D] text-xs font-semibold px-2.5 py-0.5">{{ $followups->count() }} leads</span>
                        <a href="{{ route('admin.leads.index') }}" class="text-sm font-semibold text-[#C1121F] hover:underline min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">Semua</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left">
                            <th scope="col" class="px-4 py-2.5 font-semibold text-[#16181D]">Leads</th>
                            <th scope="col" class="px-4 py-2.5 font-semibold text-[#16181D] text-right">Jatuh tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($followups as $lead)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3"><a href="{{ route('admin.leads.show', $lead) }}" class="underline font-medium text-[#16181D] min-h-[44px] inline-flex items-center rounded focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16181D]">#{{ $lead->id }} {{ $lead->customer->nama ?? '' }}</a></td>
                                <td class="px-4 py-3 text-right text-gray-500">{{ $lead->followup_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada follow-up jatuh tempo. <a href="{{ route('admin.leads.index') }}" class="font-semibold text-[#C1121F] underline">Buka leads</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </section>
        @endif

        @hasanyrole('owner|pimpinan|superadmin')
            @if (isset($grafikOmzet))
                <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm" x-data="{ level: 'tahun', tahun: '' }">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-bold text-[#16181D]" x-text="level === 'tahun' ? 'Omzet per tahun' : 'Omzet ' + tahun + ' per bulan'"></h3>
                            <p class="text-xs text-gray-500">Klik titik tahun untuk rincian bulan.</p>
                        </div>
                        <button type="button" x-show="level === 'bulan'" @click="level = 'tahun'" class="text-xs font-semibold text-[#C1121F] hover:underline min-h-[44px] inline-flex items-center rounded px-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F]">Kembali ke tahun</button>
                    </div>
                    @if (array_sum(array_column($grafikOmzet['tahun']['items'], 'nominal')) === 0)
                        <p class="mt-2 text-sm text-gray-500">Belum ada penjualan Deal pada periode ini.</p>
                    @else
                        <div x-show="level === 'tahun'">
                            <x-grafik-garis :items="$grafikOmzet['tahun']['items']" :skala="$grafikOmzet['tahun']['skala']" :klik="true" />
                        </div>
                        @foreach ($grafikOmzet['bulanan'] as $tahun => $data)
                            <div x-show="level === 'bulan' && tahun === '{{ $tahun }}'" x-cloak>
                                <x-grafik-garis :items="$data['items']" :skala="$data['skala']" />
                            </div>
                        @endforeach
                        <p class="mt-1 text-xs text-gray-500">Klik titik tahun untuk rincian bulan.</p>
                    @endif
                </div>
            @endif
        @endhasanyrole
    </div>
</x-app-layout>
