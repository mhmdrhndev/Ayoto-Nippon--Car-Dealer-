<x-site-layout judul="Cabang Kami" deskripsi="Alamat, telepon, dan lokasi cabang dealer Ayoto Nippon.">
    <x-site-header />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Cabang Kami</h1>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($branches as $branch)
                <div class="p-5 border border-gray-200 rounded-xl">
                    <h2 class="font-bold text-[#16181D]">{{ $branch->nama }}</h2>
                    <p class="mt-1 text-sm text-[#16181D]">{{ $branch->alamat }}</p>
                    <p class="text-sm text-[#4B5563]">{{ $branch->telp }}</p>
                    @if ($branch->jam_operasional)
                        <p class="mt-1 flex items-center gap-1.5 text-sm text-[#4B5563]">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 7v5l3 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>{{ $branch->jam_operasional }}</span>
                        </p>
                    @endif
                    @if ($branch->maps_url)
                        <a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center text-sm font-semibold text-[#C1121F] underline min-h-[44px]">Buka di Google Maps</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
