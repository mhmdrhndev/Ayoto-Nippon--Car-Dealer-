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
    <div class="max-w-xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Lacak SPK</h1>
        <form action="{{ route('lacak.cek') }}" method="POST" class="mt-4 space-y-3">
            @csrf
            <label for="no_spk" class="block text-sm font-medium text-[#16181D]">Nomor SPK (contoh: SPK-2026-0001)</label>
            <input id="no_spk" name="no_spk" value="{{ old('no_spk') }}" required class="w-full rounded-lg border-gray-300 font-mono min-h-[44px]">
            <x-input-error :messages="$errors->all()" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Lacak</button>
        </form>
    </div>
</x-site-layout>
