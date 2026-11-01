<x-site-layout judul="Pertanyaan Umum" deskripsi="Jawaban syarat SPK, booking fee, verifikasi, trade-in, test drive, servis, dan sparepart di Ayoto Nippon.">
    <x-site-header />

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-[#16181D]">Pertanyaan Umum</h1>
        <p class="mt-1 text-sm text-[#4B5563]">Jawaban singkat alur yang benar-benar berjalan di web ini.</p>

        <div class="mt-6 space-y-3">
            @foreach ([
                ['Apa syarat mengajukan SPK?', 'Daftar akun, pilih unit berstatus Tersedia di katalog, lalu ajukan SPK. Setelah SPK terbit, transfer booking fee ke rekening resmi cabang sebelum batas waktu.'],
                ['Berapa booking fee dan dibayar ke mana?', 'Nominal booking fee mengikuti cabang dan tercantum di halaman SPK beserta nomor rekening resmi. Bayar sebelum batas waktu yang tertulis, umumnya 24 jam.'],
                ['Apa yang terjadi bila lewat batas bayar?', 'SPK otomatis menjadi Expired dan unit dilepas kembali ke stok. Ajukan SPK baru untuk unit yang masih tersedia.'],
                ['Berapa lama verifikasi bukti bayar?', 'Admin memeriksa bukti pada jam operasional. Pantau status di Lacak SPK atau Pesanan Saya: MenungguBayar, MenungguVerifikasi, Deal, atau Ditolak.'],
                ['Bagaimana cara melacak SPK?', 'Buka Lacak SPK, masukkan nomor SPK seperti SPK-2026-0001. Masuk akun untuk melihat semua riwayat di Pesanan Saya.'],
                ['Apakah trade-in bisa digabung pembelian unit baru?', 'Bisa. Ajukan trade-in dan tautkan ke SPK aktif Anda. Tim inspeksi memberi penawaran harga yang tercatat di pengajuan.'],
                ['Apa syarat test drive?', 'Masuk akun, isi NIK dan jadwal yang diinginkan. Cabang mengonfirmasi; batalkan atau ajukan ulang dari Pesanan Saya selama status Menunggu atau Dikonfirmasi.'],
                ['Apa yang perlu disiapkan untuk servis?', 'Nomor polisi atau VIN dan keluhan unit. Estimasi biaya diinformasikan cabang; pantau status di Pesanan Saya.'],
                ['Bagaimana alur beli sparepart?', 'Pesan dari katalog sparepart, bayar sebelum deadline agar tidak kedaluwarsa, lalu ambil di cabang sesuai order SPO Anda.'],
                ['Bisakah membatalkan test drive atau servis?', 'Bisa dari Pesanan Saya selama status Menunggu atau Dikonfirmasi. Yang sudah Dikerjakan, Selesai, Hadir, atau Batal tidak bisa diubah.'],
            ] as [$tanya, $jawab])
                <details class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <summary class="px-4 py-3 font-semibold text-[#16181D] cursor-pointer min-h-[44px] flex items-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#C1121F]">{{ $tanya }}</summary>
                    <p class="px-4 pb-4 text-sm text-[#4B5563] leading-relaxed">{{ $jawab }}</p>
                </details>
            @endforeach
        </div>
    </div>

    <x-site-footer />
</x-site-layout>
