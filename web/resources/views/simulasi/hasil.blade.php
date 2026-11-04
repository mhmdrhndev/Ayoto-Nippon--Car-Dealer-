<x-site-layout judul="Hasil Simulasi Kredit" deskripsi="Rincian angsuran simulasi kredit mobil baru Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-3xl p-6 sm:p-10 shadow-2xl shadow-black/5 w-full">
            <div class="pb-6 border-b border-[#E5E7EB]">
                <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Kalkulasi Selesai</p>
                <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-[#16181D] tracking-tight">Hasil Estimasi Kredit</h1>
                <p class="mt-2 text-xs sm:text-sm text-[#4B5563]">
                    {{ $variant->carModel->brand->nama }} {{ $variant->carModel->nama }} {{ $variant->nama }} via {{ $leasing->nama }}
                </p>
            </div>

            <div class="mt-8 space-y-4">
                <div class="p-6 bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl">
                    <p class="text-xs text-[#4B5563] uppercase tracking-wider">Harga OTR Kendaraan</p>
                    <p class="mt-1 text-xl font-bold text-[#16181D] tabular-nums">Rp {{ number_format($otr, 0, ',', '.') }}</p>
                </div>

                <div class="p-6 bg-[#FFFFFF] border border-[#C1121F]/30 rounded-2xl text-center relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-[#C1121F]/10 rounded-full blur-xl pointer-events-none"></div>
                    <p class="text-xs font-semibold text-[#4B5563] uppercase tracking-wider">Estimasi Angsuran Bulanan</p>
                    <p class="mt-2 text-3xl sm:text-4xl font-black text-[#C1121F] tabular-nums">
                        Rp {{ number_format($angsuran, 0, ',', '.') }}
                        <span class="text-sm font-medium text-[#4B5563]">/bulan</span>
                    </p>
                    <p class="mt-2 text-xs text-[#4B5563]">
                        Tenor {{ $tenor }} Bulan ({{ $tenor / 12 }} Tahun) • Bunga Flat {{ $leasing->bunga_dasar }}% per tahun
                    </p>
                </div>
            </div>

            <p class="mt-6 text-xs text-[#4B5563] text-center leading-relaxed">
                Hasil perhitungan ini telah disimpan di sistem kami. Sales consultant cabang terkait akan menghubungi Anda untuk konfirmasi promo kredit dan paket asuransi.
            </p>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-3 pt-6 border-t border-[#E5E7EB]">
                <a href="{{ route('spk.create', ['variant_id' => $variant->id]) }}" 
                    class="py-3.5 px-6 text-center font-bold text-sm text-white bg-[#C1121F] hover:bg-[#9E0E19] rounded-xl shadow-lg shadow-[#C1121F]/25 transition-all min-h-[48px] flex items-center justify-center">
                    Ajukan Pemesanan SPK
                </a>
                <a href="{{ route('simulasi.form', ['variant_id' => $variant->id]) }}" 
                    class="py-3.5 px-6 text-center font-semibold text-sm text-[#4B5563] hover:text-[#16181D] bg-[#FFFFFF] border border-[#E5E7EB] hover:border-[#C1121F] rounded-xl transition-all min-h-[48px] flex items-center justify-center">
                    Hitung Ulang
                </a>
            </div>
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
