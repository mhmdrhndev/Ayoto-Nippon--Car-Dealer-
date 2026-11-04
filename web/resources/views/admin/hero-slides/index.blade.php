<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Hero Slider</h2></x-slot>
    <div class="py-6 w-full sm:px-6 lg:px-8">
        @if (session('sukses'))<p class="mb-4 p-3 text-sm bg-green-50 border border-green-200 rounded-lg">{{ session('sukses') }}</p>@endif
        <a href="{{ route('admin.hero-slides.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Tambah Foto</a>
        <div class="mt-4 bg-white rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b">
                    <th class="text-left px-4 py-3">Foto</th><th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">Urutan</th><th class="text-left px-4 py-3">Aktif</th><th class="px-4 py-3"></th>
                </tr></thead>
                <tbody>
                    @forelse ($slides as $slide)
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3"><img src="{{ asset($slide->foto) }}" alt="" class="h-12 w-20 object-cover rounded-lg"></td>
                            <td class="px-4 py-3">{{ $slide->nama }}</td>
                            <td class="px-4 py-3 tabular-nums">{{ $slide->urutan }}</td>
                            <td class="px-4 py-3">{{ $slide->aktif ? 'Ya' : 'Tidak' }}</td>
                            <td class="px-4 py-3"><a href="{{ route('admin.hero-slides.edit', $slide) }}" class="underline min-h-[44px] inline-flex items-center">Ubah</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-gray-500">Belum ada foto. Tambahkan foto pertama lewat tombol di atas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $slides->links() }}</div>
    </div>
</x-app-layout>
