<x-site-layout judul="Pertanyaan Umum (FAQ)" deskripsi="Jawaban resmi seputar alur SPK, transfer booking fee, verifikasi dokumen, trade-in, test drive, dan servis di Ayoto Nippon.">
    <x-site-header />

    <div class="w-full px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        <div class="pb-6 border-b border-[#E5E7EB]">
            <p class="text-xs font-semibold tracking-wider text-[#C1121F] uppercase">Pusat Bantuan Pelanggan</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-extrabold text-[#16181D] tracking-tight">Pertanyaan yang Sering Diajukan</h1>
            <p class="mt-2 text-sm text-[#4B5563]">
                Panduan praktis dan ketentuan resmi mengenai pemesanan unit, booking fee, verifikasi SPK, dan layanan purnajual dealer.
            </p>
        </div>

        <div class="space-y-3.5">
            @foreach ([
                ['Apa syarat mengajukan pemesanan SPK online?', 'Buat akun pelanggan, pilih unit berstatus Tersedia di katalog berdasarkan nomor rangka (VIN), lalu klik Ajukan SPK. Setelah nomor SPK terbit, transfer booking fee ke rekening resmi cabang sebelum batas waktu 24 jam.'],
                ['Berapa nominal booking fee dan dibayarkan ke mana?', 'Nominal booking fee mengikuti ketentuan cabang resmi dan tercantum secara transparan pada dokumen SPK beserta nomor rekening bank cabang resmi. Pembayaran harus diselesaikan sebelum batas waktu kedaluwarsa.'],
                ['Apa yang terjadi jika melewati batas waktu pembayaran booking fee?', 'Sistem otomatis mengubah status SPK menjadi Expired (Kedaluwarsa) dan alokasi unit fisik akan dilepaskan kembali ke katalog publik. Anda dapat mengajukan SPK baru untuk unit lain yang masih tersedia.'],
                ['Berapa lama proses verifikasi bukti transfer pembayaran?', 'Admin cabang memvalidasi bukti pembayaran pada jam operasional kerja dealer. Anda dapat memantau status secara langsung di halaman Lacak SPK atau Pesanan Saya: MenungguBayar, MenungguVerifikasi, Deal, atau Ditolak.'],
                ['Bagaimana cara melacak perkembangan pesanan kendaraan?', 'Buka menu Lacak SPK di navigasi atas, lalu masukkan nomor registrasi SPK Anda (contoh: SPK-2026-0001). Pengguna yang telah masuk akun juga dapat melihat riwayat lengkap di menu Pesanan Saya.'],
                ['Apakah tukar tambah (trade-in) bisa digabung dengan pembelian unit baru?', 'Bisa. Ajukan formulir Trade-In dan tautkan nomor SPK aktif Anda. Tim appraisal kami akan melakukan inspeksi fisik kendaraan lama Anda dan memberikan nilai taksiran sebagai pengurang uang muka.'],
                ['Apa saja persyaratan untuk mengikuti sesi test drive?', 'Masuk ke akun pelanggan, cantumkan NIK KTP serta jadwal dan varian yang diinginkan. Bawa SIM A yang masih berlaku saat menghadiri sesi uji coba di dealer cabang terpilih.'],
                ['Apa dokumen yang perlu disiapkan saat booking servis berkala?', 'Nomor polisi kendaraan atau 17 digit VIN dan catatan keluhan mesin. Estimasi biaya dan waktu pengerjaan akan diinformasikan oleh service advisor saat kedatangan.'],
                ['Bagaimana alur pembelian suku cadang asli (sparepart)?', 'Pilih part dari katalog sparepart cabang terdekat, lakukan pembayaran sesuai nomor SPO yang terbit sebelum deadline, lalu ambil langsung di gudang cabang dealer.'],
                ['Bisakah membatalkan jadwal test drive atau booking servis?', 'Pembatalan atau pengajuan jadwal ulang dapat dilakukan mandiri melalui menu Pesanan Saya selama status masih dalam tahap Menunggu atau Dikonfirmasi. Pesanan yang sudah berstatus Dikerjakan, Selesai, Hadir, atau Batal tidak dapat diubah.'],
            ] as [$tanya, $jawab])
                <details class="bg-[#FFFFFF] border border-[#E5E7EB] rounded-2xl overflow-hidden hover:border-[#C1121F] transition-colors group">
                    <summary class="px-6 py-4 font-bold text-sm sm:text-base text-[#16181D] cursor-pointer min-h-[48px] flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#C1121F] select-none">
                        <span>{{ $tanya }}</span>
                        <svg class="w-5 h-5 text-gray-500 group-open:rotate-180 group-open:text-[#C1121F] transition-transform duration-200 shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-6 pb-5 pt-1 text-xs sm:text-sm text-[#4B5563] leading-relaxed border-t border-[#E5E7EB]">
                        {{ $jawab }}
                    </div>
                </details>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
