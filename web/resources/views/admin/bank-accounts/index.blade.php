<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekening Bank</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <a href="{{ route('admin.bank-accounts.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Tambah Rekening</a>
        <div class="mt-4 bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b">
                    <th class="text-left px-4 py-3">Cabang</th><th class="text-left px-4 py-3">Bank</th>
                    <th class="text-left px-4 py-3">No. Rekening</th><th class="text-left px-4 py-3">Atas Nama</th>
                    <th class="text-left px-4 py-3">Aktif</th><th class="px-4 py-3"></th>
                </tr></thead>
                <tbody>
                    @forelse ($accounts as $account)
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3">{{ $account->branch->nama }}</td>
                            <td class="px-4 py-3">{{ $account->bank }}</td>
                            <td class="px-4 py-3 font-mono">{{ $account->no_rek }}</td>
                            <td class="px-4 py-3">{{ $account->atas_nama }}</td>
                            <td class="px-4 py-3">{{ $account->aktif ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.bank-accounts.edit', $account) }}" class="underline min-h-[44px] inline-flex items-center">Ubah</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-gray-500">Belum ada rekening. Tambahkan rekening pertama lewat tombol di atas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $accounts->links() }}</div>
    </div>
</x-app-layout>
