<x-site-layout judul="Booking Servis" deskripsi="Jadwalkan servis mobil terjadwal per cabang Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Bengkel Resmi Bersertifikasi</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Booking Jadwal Servis Berkala</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
                    Percayakan perawatan kendaraan Anda pada service advisor dan teknisi bersertifikasi pabrikan dengan suku cadang asli bergaransi resmi.
                </p>
            </div>

            <form action="{{ route('servis.store') }}" method="POST" class="mt-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="nama" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nama Pemilik / Pembawa Mobil</label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" required 
                            placeholder="Sesuai STNK / KTP"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="nik" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">NIK KTP (16 Digit)</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16" 
                            placeholder="3201..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="telp" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor WhatsApp / Telepon</label>
                        <input id="telp" name="telp" value="{{ old('telp') }}" required inputmode="tel" 
                            placeholder="0812..."
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="nopol" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor Polisi (Plat Kendaraan)</label>
                        <input id="nopol" name="nopol" value="{{ old('nopol') }}" required 
                            placeholder="Contoh: B 1234 NIP"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5 uppercase font-mono">
                    </div>

                    <div>
                        <label for="vin" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor Rangka VIN (Opsional)</label>
                        <input id="vin" name="vin" value="{{ old('vin') }}" 
                            placeholder="17 Digit VIN tertera di STNK"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm font-mono focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>

                    <div>
                        <label for="km" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Kilometer Kendaraan Saat Ini</label>
                        <input id="km" type="number" name="km" value="{{ old('km') }}" required min="0" 
                            placeholder="Contoh: 10000"
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5 tabular-nums">
                    </div>

                    <div>
                        <label for="branch_id" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Cabang Bengkel Resmi</label>
                        <select id="branch_id" name="branch_id" required 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                            <option value="" @selected(! old('branch_id'))>Pilih Cabang</option>
                            @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="jadwal" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Rencana Waktu Kedatangan</label>
                        <input id="jadwal" type="datetime-local" name="jadwal" value="{{ old('jadwal') }}" required 
                            class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[48px] px-3.5">
                    </div>
                </div>

                <div>
                    <label for="alamat" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Alamat Tempat Tinggal</label>
                    <textarea id="alamat" name="alamat" required rows="2" 
                        placeholder="Alamat domisili pemilik..."
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label for="keluhan" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Keluhan atau Paket Servis yang Diminta</label>
                    <textarea id="keluhan" name="keluhan" required rows="3" 
                        placeholder="Misal: Servis berkala 10.000 KM, ganti oli mesin, rem bunyi berdecit saat macet..."
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 text-sm focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] p-3.5">{{ old('keluhan') }}</textarea>
                </div>

                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
                        Konfirmasi Booking Servis
                    </button>
                    <p class="mt-3 text-center text-xs text-gray-500">
                        Service advisor kami akan mengonfirmasi slot stall servis dan estimasi waktu pengerjaan.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
