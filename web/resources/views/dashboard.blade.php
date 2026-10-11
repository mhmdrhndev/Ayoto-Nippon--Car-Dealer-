<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @hasanyrole('sales|admin-cabang|pimpinan|superadmin')
                <a href="{{ route('admin.verify.index') }}" class="block bg-white p-5 rounded-xl shadow-sm">
                    <p class="text-2xl font-bold tabular-nums">{{ $spkMenunggu }}</p>
                    <p class="text-sm text-gray-500">SPK menunggu verifikasi</p>
                </a>
                <a href="{{ route('admin.leads.index') }}" class="block bg-white p-5 rounded-xl shadow-sm">
                    <p class="text-2xl font-bold tabular-nums">{{ $leadsBaru }}</p>
                    <p class="text-sm text-gray-500">Leads baru</p>
                </a>
            @endhasanyrole
            @hasanyrole('service-advisor|mekanik|admin-cabang|pimpinan|superadmin')
                <a href="{{ route('admin.services.index') }}" class="block bg-white p-5 rounded-xl shadow-sm">
                    <p class="text-2xl font-bold tabular-nums">{{ $servisAktif }}</p>
                    <p class="text-sm text-gray-500">Servis aktif</p>
                </a>
            @endhasanyrole
            <div class="bg-white p-5 rounded-xl shadow-sm">
                <p class="text-2xl font-bold tabular-nums">{{ $unitTersedia }}</p>
                <p class="text-sm text-gray-500">Unit tersedia</p>
            </div>
            @if (isset($leadsSaya))
                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <p class="text-2xl font-bold tabular-nums">{{ $leadsSaya }}</p>
                    <p class="text-sm text-gray-500">Leads saya ({{ $followupJatuh }} jatuh tempo)</p>
                </div>
            @endif
            @if (isset($tugasSaya))
                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <p class="text-2xl font-bold tabular-nums">{{ $tugasSaya }}</p>
                    <p class="text-sm text-gray-500">Servis tugas saya</p>
                </div>
            @endif
            @if (isset($spkSaya))
                <div class="bg-white p-5 rounded-xl shadow-sm">
                    <p class="text-2xl font-bold tabular-nums">{{ $spkSaya }}</p>
                    <p class="text-sm text-gray-500">SPK saya</p>
                </div>
            @endif
        </div>

        @hasanyrole('owner|pimpinan|superadmin')
            @if (isset($grafikOmzet))
                <div class="bg-white p-5 rounded-xl shadow-sm max-w-3xl" x-data="{ level: 'tahun', tahun: '' }">
                    <style>[x-cloak]{display:none!important}</style>
                    <div class="flex items-center justify-between gap-3">
                        <h3 class="font-bold text-[#16181D]" x-text="level === 'tahun' ? 'Omzet per tahun' : 'Omzet ' + tahun + ' per bulan'"></h3>
                        <button type="button" x-show="level === 'bulan'" @click="level = 'tahun'" class="text-xs font-semibold text-[#C1121F] hover:underline min-h-[44px] inline-flex items-center">Kembali ke tahun</button>
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
        @hasanyrole('sales|admin-cabang|pimpinan|superadmin')
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b"><th class="text-left px-4 py-3">SPK terbaru</th><th class="text-left px-4 py-3">Customer</th><th class="text-left px-4 py-3">Status</th></tr></thead>
                    <tbody>
                        @forelse ($spkTerbaru as $order)
                            <tr class="border-b last:border-0">
                                <td class="px-4 py-3 font-mono">{{ $order->no_spk }}</td>
                                <td class="px-4 py-3">{{ $order->customer->nama }}</td>
                                <td class="px-4 py-3">{{ $order->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-6 text-gray-500">Belum ada SPK.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endhasanyrole
    </div>
</x-app-layout>
