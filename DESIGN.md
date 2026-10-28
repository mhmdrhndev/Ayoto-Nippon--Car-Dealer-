# DESIGN.md: Web App Dealer Mobil PT Ayoto Nippon

**Status:** DRAF arah visual, disusun agent atas permintaan pemilik (bukan dari brand book resmi).
**Peringatan:** arah visual buatan agent cenderung ke selera AI default sehingga berisiko monoton. Dokumen ini ditulis spesifik untuk konteks dealer mobil Ayoto Nippon, dan semua yang belum terkonfirmasi ditandai `[LOGO]` atau `[REAL DATA]`. Kunci palet, font, dan logo resmi sebelum dipakai ke kode Tailwind.
**Acuan:** PRD v1.0 Final (PRD-Ayoto-Nippon-Full-Dealer.md), Proposal (PROPOSAL-Ayoto-Nippon.md).
**Tanggal:** 23 September 2026.
**Mode antislop:** DURING, skill terpasang Semua (UI, copy, human, layoutmobile, code).

Reading this as: katalog dan alur SPK dealer mobil untuk pembeli umum plus panel admin 7 peran, dalam bahasa visual showroom resmi yang tenang, dial ENERGY 1 / RHYTHM 2 / MOTION 1.

## 1. Produk dan audiens

Produk ini punya dua wajah. Wajah publik untuk pembeli mobil: buka katalog di HP, bandingkan harga OTR, ajukan SPK, lacak status. Wajah internal untuk 7 peran: sales memegang leads, admin cabang memegang stok dan verifikasi, SA dan mekanik memegang servis, pimpinan membaca laporan.

Keputusan: wajah publik mengutamakan kecepatan dan kejelasan harga. Wajah internal mengutamakan kepadatan informasi yang tetap terbaca. Alasan satu baris: pembeli memutuskan dari foto, harga, dan status stok, sedangkan staf memutuskan dari tabel dan antrean.

## 2. Kepribadian

Tenang, resmi, dan dapat dipercaya seperti showroom fisik. Tidak ramai, tidak agresif. Halaman promo boleh lebih hidup, tetapi kerangka dasarnya tetap sama agar pelanggan yang dari banner promo ke halaman SPK merasa berada di tempat yang sama.

## 3. Dial dan tuas liveliness

Dial: ENERGY 1 / RHYTHM 2 / MOTION 2 (halaman publik; area admin tetap 1).

Alasan satu baris per dial: ENERGY 1 karena pembeli mobil butuh rasa aman, bukan sensasi. RHYTHM 2 karena katalog butuh variasi (galeri, spesifikasi, simulasi) tanpa kehilangan keteraturan. MOTION 2 karena halaman publik memakai scroll-reveal sekali tampil pada momen keputusan; admin tetap 1 agar fokus kerja.

Tuas yang dipakai:

* Satu titik fokus per layar. Di halaman detail mobil: foto unit dan harga OTR. Di antrean verifikasi: bukti bayar yang menunggu keputusan.
* Kontras hierarki: harga dan status SPK selalu paling menonjol, informasi pendukung mengecil.
* Whitespace sebagai struktur: jarak antar tahap alur SPK lebih besar daripada jarak antar field formulir, agar tahap terbaca sebagai urutan.
* Satu aksen disengaja: merah otomotif hanya di momen kunci (lihat Pasal 4).
* Motif identitas: penanda tahap alur. Satu bentuk penanda status yang sama dipakai di lacak SPK publik, timeline admin, dan papan servis. Alasan satu baris: pelanggan dan staf membaca status yang sama dengan bahasa visual yang sama.

## 4. Palet (DRAF, perlu konfirmasi brand)

Batas aktif: 2 warna inti netral + 1 warna pekat teks + 1 aksen. Nilai di bawah ini usulan agent, bukan warna brand resmi.

| Peran | Nilai draf | Alasan satu baris |
|---|---|---|
| Latar dasar | Putih `#FFFFFF` | Katalog mobil dibaca paling cepat di latar terang |
| Teks utama | Tinta `#16181D` | Kontras 17.76:1 di putih, terverifikasi script |
| Teks sekunder | Abu steel `#4B5563` | Kontras 7.56:1 di putih, untuk label dan info pendukung |
| Aksen momen kunci | Merah `#C1121F` | Sinyal otomotif yang familier, dipakai hemat |

Aturan aksen: merah hanya untuk CTA utama pengajuan SPK, status SPK yang butuh tindakan (MenungguBayar, MenungguVerifikasi), dan penanda tahap aktif. Harga dalam teks memakai tinta, bukan merah. Alasan satu baris: aksen yang muncul di mana-mana berhenti menjadi penanda.

Verifikasi kontras (script contrast-check.py, 23 Sep 2026): tinta di putih 17.76 PASS, abu steel di putih 7.56 PASS, merah di putih 6.22 PASS, putih di merah 6.22 PASS. Teks di atas foto unit wajib memakai lapisan gelap solid di belakang teks, lalu diverifikasi di titik paling terang foto, bukan titik paling gelap.

Yang dilarang: gradien biru ungu sebagai identitas, glow latar, grid blueprint, glassmorphism di lebih dari 1 elemen, bayangan besar di semua kartu. Alasan satu baris: tidak satu pun berasal dari identitas Ayoto Nippon.

## 5. Tipografi (DRAF, perlu konfirmasi)

Satu keluarga sans untuk seluruh UI, dengan angka tabular untuk harga, tabel stok, dan angsuran. Alasan satu baris: harga Rp 100 juta yang angkanya tidak sejajar antar baris membuat perbandingan OTR sulit dibaca.

Usulan draf: Inter dengan fallback sistem (`Inter, system-ui, Segoe UI, Arial, sans-serif`). Alasan satu baris: Inter menyediakan angka tabular dan sudah teruji di tabel padat admin. Jika pemilik memilih font lain yang punya angka tabular, keputusan ini diganti tanpa mengubah struktur.

Mono dipakai hanya untuk pengenal: VIN, nomor SPK, nomor servis. Alasan satu baris: pengenal dibedakan dari kalimat agar mudah disalin dan diverifikasi, bukan untuk gaya terminal.

Ukuran mengikuti skala responsif: judul hero lebih kecil di HP lewat `clamp()` atau anak tangga breakpoint, bukan satu ukuran px untuk semua layar. Alasan satu baris: judul yang pas di desktop menutupi layar HP.

## 6. Pola halaman publik

Struktur tiap halaman mengikuti kebutuhan kontennya, bukan template baku. Tidak ada bar testimoni, tidak ada bar angka statistik, tidak ada FAQ sampai ada data dan pertanyaan asli (R-17, R-18, R-28, R-38).

* Home: fokus ke pencarian mobil dan promo aktif per cabang. Urutan: navigasi cabang, jalur ke katalog, promo berjalan, info cabang. Alasan satu baris: pengunjung datang untuk mencari unit atau promo, bukan membaca klaim.
* Katalog: fokus ke filter (brand, transmisi, BBM, rentang harga, cabang) dan kartu unit dengan foto, harga OTR per cabang, status stok. Unit Dipesan atau Terjual tampil tidak bisa dipilih untuk SPK baru. Alasan satu baris: status stok adalah informasi keputusan, bukan hiasan.
* Detail mobil: fokus ke galeri, spesifikasi, harga OTR cabang, tombol Ajukan SPK dan Minta Dihubungi Sales. Alasan satu baris: dua tombol itu adalah dua ujung konversi yang dicatat PRD.
* Simulasi kredit: fokus ke input DP, tenor, leasing dan hasil angsuran, dengan tombol Ajukan SPK. Alasan satu baris: hasil simulasi wajib tersimpan sebagai leads, jadi halaman ini jembatan, bukan kalkulator lepas.
* Lacak SPK: fokus ke timeline status dan instruksi transfer (bank cabang, nominal, deadline) plus area upload bukti yang hanya aktif saat MenungguBayar. Alasan satu baris: pelanggan yang cemas butuh satu jawaban, yaitu posisi SPK saya sekarang.
* Navigasi publik hanya memuat halaman yang ada: Katalog, Simulasi Kredit, Promo, Trade-In, Test Drive, Servis Booking, Lacak SPK, Cabang. Alasan satu baris: setiap item nav wajib punya tujuan nyata.

## 7. Pola layar admin (per pekerjaan, bukan cangkang generik)

Setiap layar admin dibangun dari keputusan yang diambil penggunanya, bukan dari pola sidebar plus 4 kartu statistik plus grafik plus tabel.

* Verifikasi SPK: fokus ke bukti bayar (preview), data SPK, tombol Terima atau Tolak dengan alasan wajib saat tolak. Alasan satu baris: keputusan admin adalah terima atau tolak, jadi bukti adalah halaman.
* Stok unit: kolom VIN, varian, warna, cabang, tahun rakit, harga, status, aksi. Alasan satu baris: itulah field yang membedakan satu unit dari unit lain.
* Leads: pipeline Baru, Dihubungi, TestDrive, SPK, Deal, Batal, dengan assign sales dan log follow-up. Alasan satu baris: sales bekerja dari antrean follow-up, bukan dari angka hiasan.
* Servis: papan status Menunggu, Dikonfirmasi, Dikerjakan, Selesai, Batal per booking, dengan estimasi SA dan detail pekerjaan mekanik. Alasan satu baris: SA dan mekanik butuh posisi tiap kendaraan, bukan ringkasan umum.
* Laporan pimpinan: penjualan, konversi leads, stok aging, servis, komisi, per periode dan per cabang, plus export Excel. Setiap angka wajib dari data asli, delta tren hanya tampil jika periode pembandingnya nyata dan tertulis. Alasan satu baris: angka laporan dipakai mengambil keputusan bisnis.
* Angka, feed aktivitas, dan baris tabel prototipe memakai data asli atau placeholder jujur (`[REAL DATA]`, nama field kosong yang jelas). Alasan satu baris: data palsu yang terlihat asli merusak kepercayaan pimpinan.

## 8. Komponen

* Tombol: radius konsisten dari sistem (contoh draf: 8px tombol, 12px kartu), bukan semua pil. Tombol utama memakai aksen merah hanya satu per layar. Alasan satu baris: satu CTA utama menghilangkan keraguan klik berikutnya.
* Badge status SPK dan servis: label fungsional dengan teks (contoh: MenungguBayar, Dikerjakan), selalu dipasangkan teks bukan warna saja. Alasan satu baris: status yang hanya mengandalkan warna hilang bagi pengguna buta warna.
* Formulir SPK: label jelas, validasi server-side (NIK 16 digit, telp 10 sampai 15 digit), upload KTP dan bukti JPG/PNG/PDF maks 2 MB dengan pesan error yang menyebut syaratnya. Alasan satu baris: pelanggan gagal upload butuh tahu syaratnya, bukan sekadar bingkai merah.
* Fokus keyboard: indikator `:focus-visible` 2px kontras di semua kontrol, tidak pernah `outline: none` tanpa pengganti. Dialog modal bisa ditutup Escape. Alasan satu baris: verifikasi dan SPK harus bisa dikerjakan penuh dari keyboard.

## 9. State wajib tiap tampilan data

Setiap tampilan data punya tiga state dengan kalimat spesifik produk, bukan generik:

* Kosong katalog cabang: "Belum ada unit Tersedia di cabang ini. Ubah filter atau hubungi sales cabang." plus tombol Lihat Semua Cabang.
* Kosong riwayat servis: "Belum ada riwayat servis untuk VIN ini." plus tombol Booking Servis.
* Loading: menyebut yang dimuat ("Memuat stok cabang ...").
* Error: menyebut yang gagal dan langkah berikut ("Gagal memuat bukti bayar. Muat ulang halaman atau hubungi admin cabang.").

## 10. Responsif dan mobile

Mobile adalah layout tersendiri, bukan desktop yang disempitkan. Breakpoint dipasang di lebar tempat konten rusak (kolom tabel mulai bertumpuk, kartu terlalu sempit), bukan meniru daftar ukuran HP tertentu.

* Katalog: grid multi kolom runtuh menjadi satu kolom di layar sempit, ukuran huruf dan padding turun satu anak tangga, tidak ada scroll horizontal.
* Tabel admin padat (stok, laporan): di layar sempit berubah menjadi daftar kartu per baris dengan field keputusan lebih dulu (VIN dan status di atas). Alasan satu baris: di HP, keputusan dibaca vertikal, bukan horizontal.
* Target sentuh minimal 44px dengan jarak antar target, interaksi hover selalu punya padanan tap, formulir menggulir ke field yang fokus agar tidak tertutup keyboard HP.
* Navigasi HP memakai menu berlabel jelas, bukan ikon hamburger tanpa label. Menu tidak menutupi tombol kirim formulir.

## 11. Copy dan CTA

CTA spesifik tindakan: "Ajukan SPK", "Upload Bukti Bayar", "Minta Dihubungi Sales", "Booking Test Drive", "Booking Servis", "Lacak SPK". Tanpa "Get Started", "Learn More", atau padanannya. Tanpa buzzword (tanpa seamless, revolusioner, cutting edge, AI powered). Tanpa em dash di teks UI, gunakan koma, titik, titik dua, atau kurung.

## 12. Komentar kode (untuk implementasi nanti)

Komentar menjelaskan alasan yang tidak terlihat di kode (aturan 1 VIN 1 SPK aktif, expiry scheduler tiap jam, storage private untuk KTP dan bukti), satu baris per blok logika, tanpa banner dekoratif, tanpa narasi langkah, tanpa emoji. Alasan satu baris: komentar yang mengulang kode menggandakan beban baca.

## 13. Konfirmasi terbuka untuk pemilik

1. Logo resmi atau placeholder `[LOGO]` dipertahankan? (asal file logo)
2. Palet brand resmi (ganti nilai draf Pasal 4 atau kunci?)
3. Font resmi (pertahankan usulan atau ganti?)
4. Foto unit, foto cabang, dan peta: aset asli atau placeholder awal?
5. Template teks WA (instruksi SPK, reminder H-6 jam, H-1 servis) memakai redaksi dari tim Ayoto?

## 14. Catatan penerapan

Dokumen ini adalah arah, bukan klaim kepatuhan atau klaim performa. Tidak ada skor, sertifikasi, atau statistik di dalamnya. Saat implementasi dimulai, tiap layar diverifikasi dengan build nyata dan klik tiap kontrol beserta bukti, di tema yang dikirim dan di breakpoint HP, sebelum dinyatakan selesai.
