<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Price List</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <a href="{{ route('admin.price-lists.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Tambah Harga</a>
        <div class="mt-4 bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b">
                    <th class="text-left px-4 py-3">Varian</th><th class="text-left px-4 py-3">Cabang</th>
                    <th class="text-right px-4 py-3">OTR</th><th class="text-right px-4 py-3">Diskon</th><th class="px-4 py-3"></th>
                </tr></thead>
                <tbody>
                    @forelse ($prices as $price)
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3">{{ $price->variant->carModel->brand->nama }} {{ $price->variant->carModel->nama }} {{ $price->variant->nama }}</td>
                            <td class="px-4 py-3">{{ $price->branch->nama }}</td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ number_format($price->otr, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ number_format($price->diskon, 0, ',', '.') }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.price-lists.edit', $price) }}" class="underline min-h-[44px] inline-flex items-center">Ubah</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-gray-500">Belum ada harga. Tambahkan harga pertama lewat tombol di atas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $prices->links() }}</div>
    </div>
</x-app-layout>
