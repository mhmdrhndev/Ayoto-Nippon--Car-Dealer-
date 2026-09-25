<x-site-layout>
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 min-h-[44px]">
                <img src="{{ asset('images/logo-an.png') }}" alt="Logo Ayoto Nippon" class="h-10 w-10 object-contain">
                <span class="text-xl font-bold text-[#16181D]">Ayoto Nippon</span>
            </a>
            <a href="{{ route('katalog.index') }}" class="px-3 py-2 text-sm font-medium text-[#16181D] hover:underline min-h-[44px] inline-flex items-center">Katalog</a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Cabang Kami</h1>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($branches as $branch)
                <div class="p-5 border border-gray-200 rounded-xl">
                    <h2 class="font-bold text-[#16181D]">{{ $branch->nama }}</h2>
                    <p class="mt-1 text-sm text-[#16181D]">{{ $branch->alamat }}</p>
                    <p class="text-sm text-[#4B5563]">{{ $branch->telp }}</p>
                    @if ($branch->maps_url)
                        <a href="{{ $branch->maps_url }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center text-sm font-semibold text-[#C1121F] underline min-h-[44px]">Buka di Google Maps</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-site-layout>
