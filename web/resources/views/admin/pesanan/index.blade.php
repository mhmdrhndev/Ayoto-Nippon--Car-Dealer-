<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Pesanan & Serah Terima</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))
            <p class="mb-4 p-3 text-sm bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 rounded-lg">{{ session('sukses') }}</p>
        @endif

        <form method="GET" action="{{ route('admin.pesanan.index') }}" class="mb-4 flex flex-wrap items-end gap-3">
            <div>
                <label for="filter-status" class="block text-xs font-semibold uppercase tracking-wider text-muted mb-1.5">Filter Status</label>
                <select id="filter-status" name="status" onchange="this.form.submit()" class="bg-surface border-line text-ink rounded-lg text-sm min-h-[44px] min-w-56">
                    <option value="">Semua status</option>
                    @foreach ($daftarStatus as $pilihan)
                        <option value="{{ $pilihan }}" @selected($status === $pilihan)>{{ $pilihan === 'Lunas' ? 'Lunas (invoice lunas)' : ($pilihan === 'Batal' ? 'Batal / Expired / Ditolak' : $pilihan) }}</option>
                    @endforeach
                </select>
            </div>
            @if ($status)
                <a href="{{ route('admin.pesanan.index') }}" class="text-sm font-semibold text-accent hover:underline min-h-[44px] inline-flex items-center">Reset filter</a>
            @endif
        </form>

        @if ($orders->isEmpty())
            <div class="bg-surface p-6 rounded-xl shadow-sm">
                <p class="font-semibold text-ink">Tidak ada pesanan.</p>
                <p class="text-sm text-muted mt-1">Belum ada SPK yang cocok dengan filter ini.</p>
            </div>
        @else
            <div class="bg-surface rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-line">
                            <th class="text-left px-4 py-3 font-semibold text-ink">No. SPK</th>
                            <th class="text-left px-4 py-3 font-semibold text-ink">Pelanggan</th>
                            <th class="text-left px-4 py-3 font-semibold text-ink">Unit</th>
                            <th class="text-left px-4 py-3 font-semibold text-ink">Cabang</th>
                            <th class="text-left px-4 py-3 font-semibold text-ink">Status</th>
                            <th class="text-left px-4 py-3 font-semibold text-ink">Jadwal serah terima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b border-line last:border-0 align-top">
                                <td class="px-4 py-3">
                                    <a href="{{ route('spk.show', $order->no_spk) }}" class="font-mono font-semibold text-accent hover:underline min-h-[44px] inline-flex items-center">{{ $order->no_spk }}</a>
                                    <p class="text-xs text-muted tabular-nums">{{ $order->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-ink">{{ $order->customer->nama }}</p>
                                    <p class="text-xs text-muted">{{ $order->customer->telp }}</p>
                                    <a href="{{ \App\Support\Wa::chat($order->customer->telp, 'Halo '.$order->customer->nama.', saya dari Ayoto Nippon mengenai pesanan '.$order->no_spk.'.') }}" target="_blank" rel="noopener" class="underline font-medium text-xs min-h-[44px] inline-flex items-center">Chat WA</a>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-ink">{{ $order->unit->variant->carModel->brand->nama }} {{ $order->unit->variant->carModel->nama }} {{ $order->unit->variant->nama }}</p>
                                    <p class="text-xs text-muted font-mono">{{ $order->unit->vin }}</p>
                                    <p class="text-xs text-muted tabular-nums">Rp {{ number_format($order->unit->harga, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-4 py-3 text-ink">{{ $order->branch->nama }}</td>
                                <td class="px-4 py-3"><x-status-badge :status="$order->statusTampil()" /></td>
                                <td class="px-4 py-3">
                                    @if ($order->status === 'Deal')
                                        <form action="{{ route('admin.pesanan.update', $order) }}" method="POST" class="space-y-2 min-w-64">
                                            @csrf @method('PATCH')
                                            <div>
                                                <label for="serah-{{ $order->id }}" class="block text-[11px] font-semibold uppercase tracking-wider text-muted mb-1">Unit siap diambil</label>
                                                <input id="serah-{{ $order->id }}" type="datetime-local" name="jadwal_serah_at" value="{{ $order->jadwal_serah_at?->format('Y-m-d\TH:i') }}" class="w-full rounded-lg border-line text-ink text-sm min-h-[44px]">
                                            </div>
                                            <div>
                                                <label for="stnk-{{ $order->id }}" class="block text-[11px] font-semibold uppercase tracking-wider text-muted mb-1">STNK dan BPKB selesai</label>
                                                <input id="stnk-{{ $order->id }}" type="datetime-local" name="stnk_selesai_at" value="{{ $order->stnk_selesai_at?->format('Y-m-d\TH:i') }}" class="w-full rounded-lg border-line text-ink text-sm min-h-[44px]">
                                            </div>
                                            <button class="w-full px-4 py-2 text-sm font-semibold text-surface bg-ink rounded-lg min-h-[44px]">Simpan</button>
                                        </form>
                                        @if ($order->bast_at)
                                            <p class="mt-2 text-xs text-emerald-700 dark:text-emerald-300 tabular-nums">Diserahkan {{ $order->bast_at->format('d M Y H:i') }}</p>
                                        @endif
                                    @else
                                        <p class="text-xs text-muted">Aktif setelah SPK berstatus Deal.</p>
                                        @if ($order->jadwal_serah_at)
                                            <p class="text-xs text-ink tabular-nums mt-1">{{ $order->jadwal_serah_at->format('d M Y H:i') }}</p>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $orders->links() }}</div>
        @endif
    </div>
</x-app-layout>
