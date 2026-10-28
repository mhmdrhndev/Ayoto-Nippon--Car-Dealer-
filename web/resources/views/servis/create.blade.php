<x-site-layout judul="Booking Servis" deskripsi="Jadwalkan servis mobil terjadwal per cabang Ayoto Nippon.">
    <x-site-header />
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Booking Servis</h1>
        <form action="{{ route('servis.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-[#16181D]">Nama lengkap</label>
                    <input id="nama" name="nama" value="{{ old('nama') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-[#16181D]">NIK (16 digit)</label>
                    <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="telp" class="block text-sm font-medium text-[#16181D]">No. telepon</label>
                    <input id="telp" name="telp" value="{{ old('telp') }}" required inputmode="tel" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="nopol" class="block text-sm font-medium text-[#16181D]">Nomor polisi</label>
                    <input id="nopol" name="nopol" value="{{ old('nopol') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="vin" class="block text-sm font-medium text-[#16181D]">VIN (opsional)</label>
                    <input id="vin" name="vin" value="{{ old('vin') }}" class="mt-1 w-full rounded-lg border-gray-300 font-mono min-h-[44px]">
                </div>
                <div>
                    <label for="km" class="block text-sm font-medium text-[#16181D]">Kilometer</label>
                    <input id="km" type="number" name="km" value="{{ old('km') }}" required min="0" class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
                <div>
                    <label for="branch_id" class="block text-sm font-medium text-[#16181D]">Cabang</label>
                    <select id="branch_id" name="branch_id" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                        <option value="" @selected(! old('branch_id'))>Pilih cabang</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="jadwal" class="block text-sm font-medium text-[#16181D]">Jadwal</label>
                    <input id="jadwal" type="datetime-local" name="jadwal" value="{{ old('jadwal') }}" required class="mt-1 w-full rounded-lg border-gray-300 min-h-[44px]">
                </div>
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-[#16181D]">Alamat</label>
                <textarea id="alamat" name="alamat" required rows="2" class="mt-1 w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>
            </div>
            <div>
                <label for="keluhan" class="block text-sm font-medium text-[#16181D]">Keluhan</label>
                <textarea id="keluhan" name="keluhan" required rows="2" class="mt-1 w-full rounded-lg border-gray-300">{{ old('keluhan') }}</textarea>
            </div>
            <x-input-error :messages="$errors->all()" />
            <button type="submit" class="w-full px-6 py-3 font-semibold text-white bg-[#C1121F] rounded-lg min-h-[44px]">Booking Servis</button>
        </form>
    </div>
</x-site-layout>
