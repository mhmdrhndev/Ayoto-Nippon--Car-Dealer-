<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">Laporan {{ $jenis }}</h2></x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-3 flex-1">
                <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-lg border-gray-300 text-sm min-h-[44px]">
                <button class="px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Filter</button>
            </form>
            <a href="{{ route('admin.laporan.export', array_merge(['jenis' => $jenis], request()->only(['dari', 'sampai']))) }}" class="px-4 py-2 text-sm font-semibold text-[#16181D] border border-gray-300 rounded-lg min-h-[44px] inline-flex items-center">Export Excel</a>
        </div>
        @if (empty($rows))
            <div class="bg-white p-6 rounded-xl shadow-sm"><p class="font-semibold">Tidak ada data.</p><p class="text-sm text-gray-500">Ubah rentang tanggal atau cabang.</p></div>
        @else
            <div class="bg-white rounded-xl shadow-sm overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="border-b">
                        @foreach ($headers as $h)<th class="text-left px-4 py-3">{{ $h }}</th>@endforeach
                    </tr></thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr class="border-b last:border-0">
                                @foreach ($row as $i => $cell)
                                    <td class="px-4 py-3 {{ $i > 0 && is_numeric($cell) ? 'text-right tabular-nums' : '' }}">{{ is_numeric($cell) && $cell > 999 ? number_format($cell, 0, ',', '.') : $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
