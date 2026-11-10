<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Laporan</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach (['penjualan' => 'Penjualan', 'leads' => 'Leads dan konversi', 'stok' => 'Stok aging', 'servis' => 'Servis dan pendapatan', 'komisi' => 'Komisi sales'] as $jenis => $label)
                <a href="{{ route('admin.laporan.show', $jenis) }}" class="block p-5 bg-surface rounded-xl shadow-sm hover:shadow min-h-[44px]">
                    <span class="font-bold">{{ $label }}</span>
                    <span class="block text-sm text-muted">Lihat dan export Excel</span>
                </a>
            @endforeach
        </div>
        <p class="mt-4 text-sm text-muted">Tarif komisi 1% bersifat sementara dan perlu ketetapan direksi.</p>
    </div>
</x-app-layout>
