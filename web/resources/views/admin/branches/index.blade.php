<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Cabang</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <a href="{{ route('admin.branches.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Tambah Cabang</a>
        <div class="mt-4 bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b"><th class="text-left px-4 py-3">Kode</th><th class="text-left px-4 py-3">Nama</th><th class="text-right px-4 py-3">Booking fee</th><th class="px-4 py-3"></th></tr></thead>
                <tbody>
                    @forelse ($branches as $branch)
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">{{ $branch->kode }}</td>
                            <td class="px-4 py-3 font-medium">{{ $branch->nama }}</td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ number_format($branch->booking_fee, 0, ',', '.') }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.branches.edit', $branch) }}" class="underline min-h-[44px] inline-flex items-center">Ubah</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-gray-500">Belum ada cabang.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $branches->links() }}</div>
    </div>
</x-app-layout>
