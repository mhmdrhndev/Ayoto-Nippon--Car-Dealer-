<x-site-layout judul="Lacak SPK" robots="noindex, nofollow" deskripsi="Pantau status surat pemesanan kendaraan Anda di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 relative overflow-hidden w-full">
            <div class="absolute -top-20 -right-20 w-44 h-44 bg-[#C1121F]/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pelacakan Pemesanan</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Lacak Status Dokumen SPK</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563] leading-relaxed">
                    Masukkan nomor registrasi SPK Anda untuk memeriksa alokasi unit fisik, verifikasi tanda jadi, dan jadwal serah terima.
                </p>
            </div>

            <form action="{{ route('lacak.cek') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="no_spk" class="block text-xs font-semibold uppercase tracking-wider text-[#4B5563]">Nomor Registrasi SPK</label>
                    <input id="no_spk" name="no_spk" value="{{ old('no_spk') }}" required 
                        placeholder="Contoh: SPK-2026-0001"
                        class="mt-1.5 w-full bg-[#FFFFFF] border border-[#E5E7EB] rounded-xl text-[#16181D] placeholder-gray-500 font-mono text-base tracking-wider focus:border-[#C1121F] focus:ring-1 focus:ring-[#C1121F] min-h-[50px] px-4 uppercase">
                </div>

                <x-input-error :messages="$errors->all()" class="text-[#C1121F] text-xs" />

                <button type="submit" 
                    class="w-full py-3.5 px-6 font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl min-h-[48px] shadow-lg shadow-[#C1121F]/25 transition-all flex items-center justify-center active:scale-[0.99]">
                    Lacak Dokumen Sekarang
                </button>
            </form>

            <div class="mt-8 pt-5 border-t border-[#E5E7EB] text-xs text-gray-500 text-center">
                <span>Sudah login akun? Buka </span>
                <a href="{{ route('pesanan.index') }}" class="font-semibold text-[#16181D] hover:text-[#C1121F] underline underline-offset-2">Menu Pesanan Saya</a>
                <span> untuk melihat semua transaksi.</span>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
