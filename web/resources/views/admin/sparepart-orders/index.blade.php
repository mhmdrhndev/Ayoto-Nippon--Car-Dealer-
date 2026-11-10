<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-ink leading-tight">Order Sparepart</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/30 rounded-lg">{{ session('sukses') }}</p>@endif
        @if ($orders->isEmpty())
            <div class="bg-surface p-6 rounded-xl shadow-sm"><p class="font-semibold">Belum ada order.</p><p class="text-sm text-muted">Order dari halaman beli sparepart tampil di sini.</p></div>
        @else
            <div class="bg-surface rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        <th class="text-left px-4 py-3">No. Order</th><th class="text-left px-4 py-3">Customer</th>
                        <th class="text-left px-4 py-3">Isi</th><th class="text-right px-4 py-3">Total</th>
                        <th class="text-left px-4 py-3">Status</th><th class="px-4 py-3"></th>
                    </tr></thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b last:border-0 align-top">
                                <td class="px-4 py-3 font-mono">{{ $order->no_spo }}</td>
                                <td class="px-4 py-3">{{ $order->customer->nama }}<br><span class="text-muted">{{ $order->customer->telp }}</span></td>
                                <td class="px-4 py-3">{{ $order->items->map(fn ($i) => $i->sparepart->nama.' x'.$i->qty)->join(', ') }}</td>
                                <td class="px-4 py-3 text-right tabular-nums">{{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $order->status }}</td>
                                <td class="px-4 py-3">
                                    @if ($order->status === 'MenungguBayar')
                                        <form action="{{ route('admin.sparepart-orders.confirm', $order) }}" method="POST" class="flex gap-2">
                                            @csrf @method('PATCH')
                                            <button name="aksi" value="lunas" class="px-3 py-2 text-xs font-semibold text-white bg-green-700 rounded-lg min-h-[44px]">Lunas</button>
                                            <button name="aksi" value="batal" class="px-3 py-2 text-xs font-semibold text-white bg-accent-strong rounded-lg min-h-[44px]">Batal</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
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
