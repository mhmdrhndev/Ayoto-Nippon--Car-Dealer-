<x-site-layout judul="Pengajuan Trade-In" deskripsi="Tukar tambah mobil lama Anda dengan unit baru di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Tukar Tambah Unit</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Pengajuan Trade-In Kendaraan</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
                    Tukarkan mobil lama Anda sebagai pembayaran uang muka unit baru. Tim appraisal kami akan melakukan inspeksi menyeluruh untuk memberikan penawaran harga terbaik.
                </p>
            </div>

            <form action="{{ route('trade-in.store') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nama Lengkap</label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" required 
                            placeholder="Sesuai KTP"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">NIK KTP (16 Digit)</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                            placeholder="3201..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor Telepon / WhatsApp</label>
                        <input id="telp" name="telp" value="{{ old('telp') }}" required 
                            placeholder="0812..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="merk_tipe" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Merek & Model Mobil Lama</label>
                        <input id="merk_tipe" name="merk_tipe" value="{{ old('merk_tipe') }}" required 
                            placeholder="Misal: Toyota Yaris 1.5 G AT"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="tahun" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Tahun Pembuatan</label>
                        <input id="tahun" type="number" name="tahun" value="{{ old('tahun') }}" required 
                            placeholder="Contoh: 2020"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5 tabular-nums">
                    </div>

                    <div>
                        <label for="km" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Jarak Tempuh (Kilometer Odometer)</label>
                        <input id="km" type="number" name="km" value="{{ old('km') }}" required min="0" 
                            placeholder="Contoh: 45000"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5 tabular-nums">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Domisili Inspeksi</label>
                    <textarea id="alamat" name="alamat" required rows="2" 
                        placeholder="Alamat lokasi unit mobil lama saat ini..."
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('alamat') }}</textarea>
                </div>

                @if ($orders->isNotEmpty())
                    <div>
                        <label for="order_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Tautkan ke SPK Unit Baru (Opsional)</label>
                        <select id="order_id" name="order_id" 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="">Tanpa Tautan SPK</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}">{{ $order->no_spk }} ({{ $order->unit->variant->nama ?? 'Unit Baru' }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label for="foto" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Unggah Foto Kendaraan (Maksimal 3 File, JPG/PNG, 2MB per file)</label>
                    <div class="mt-1.5 p-4 bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl flex flex-col items-center justify-center text-center">
                        <input id="foto" type="file" name="foto[]" multiple accept=".jpg,.jpeg,.png" 
                            class="w-full text-xs text-[#4B5563] file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#C1121F] file:text-white hover:file:bg-[#9E0E19] cursor-pointer">
                    </div>
                </div>

                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
                        Kirim Formulir Trade-In
                    </button>
                    <p class="mt-3 text-center text-xs text-gray-500">
                        Tim appraisal dealer resmi kami akan menghubungi Anda untuk konfirmasi jadwal inspeksi fisik.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
