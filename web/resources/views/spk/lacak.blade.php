<x-site-layout judul="Lacak SPK" robots="noindex, nofollow" deskripsi="Pantau status surat pemesanan kendaraan Anda di Ayoto Nippon.">
    <x-site-header />
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
