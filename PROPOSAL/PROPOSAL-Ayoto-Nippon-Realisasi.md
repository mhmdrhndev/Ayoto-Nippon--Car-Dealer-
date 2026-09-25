# Proposal Realisasi: Web App Dealer Mobil PT Ayoto Nippon v1.0

**Dokumen:** Laporan realisasi pembangunan, format proposal
**Acuan:** PRD v1.0 Final (PRD-Ayoto-Nippon-Full-Dealer.md), Proposal biaya (PROPOSAL/PROPOSAL-Ayoto-Nippon.md), arah visual (DESIGN.md)
**Tanggal realisasi:** 23 September 2026
**Lingkup disesuaikan:** tugas kelompok kuliah (tanpa hosting, tanpa Sanctum, tanpa backup otomatis)

---

## 1. Ringkasan Eksekusi

Seluruh milestone M1 sampai M4 selesai dan terverifikasi di lingkungan dev (Laravel 11, MariaDB XAMPP, `php artisan serve`). Total 16 modul PRD dikerjakan, 15 modul lolos uji hijau, 1 modul (testimoni) sengaja tidak dibuat karena tidak ada data asli.

Penyesuaian dari proposal awal: proyek ini dikunci sebagai tugas kuliah sehingga item produksi (Sanctum, deploy VPS, backup otomatis cron, kredensial WA gateway) dicoret atas persetujuan. Tidak ada perubahan pada 16 modul fungsional.

## 2. Hasil per Milestone

### M1: Fondasi dan katalog (hijau)

* Auth Breeze + 7 role Spatie (superadmin, pimpinan, admin-cabang, sales, service-advisor, mekanik, customer). Login customer ke home, login staf ke dashboard.
* Master: 32 brand, 239 model, 328 varian (10 per brand), 582 unit per VIN, price list per cabang, rekening bank, 3 leasing, booking fee Rp 5.000.000 per cabang.
* Katalog publik: filter brand, transmisi, BBM, cabang, harga, pencarian. Halaman detail dengan galeri, spesifikasi, OTR dan stok per cabang, CTA menempel di HP.

### M2: SPK, simulasi, leads, test drive (hijau)

* Simulasi kredit (DP, tenor, leasing) yang selalu tersimpan sebagai leads.
* SPK online: nomor SPK-YYYY-NNNN dalam transaction + lock, 1 VIN untuk 1 SPK aktif (SPK kedua ditolak 422, teruji), deadline +24 jam, upload KTP/KK, instruksi transfer.
* Lacak SPK publik + upload bukti (menjadi MenungguVerifikasi) + klaim NIK otomatis ke akun login.
* Verifikasi admin: antrean, preview, Terima (Deal + unit Terjual + invoice PDF + audit verified_by/at) atau Tolak (alasan wajib, deadline baru atau batal + lepas VIN).
* Scheduler expire tiap jam (teruji: SPK lewat deadline jadi Expired, unit kembali Tersedia).
* CRM: pipeline 6 status, assign sales, log follow-up + pengingat. Test drive: pengajuan + konfirmasi + daftar admin.
* Admin CRUD: unit, price list (perubahan tercatat di audit log), rekening bank.

### M3: After-sales dan notifikasi (hijau)

* Trade-in: pengajuan + foto, Inspeksi, Ditawar, Deal/Ditolak, taut ke SPK.
* Servis: booking dengan batas 5 slot per cabang per jam (slot ke-6 ditolak 422, teruji), konfirmasi + estimasi + mekanik, rincian pekerjaan dan sparepart, Selesai mengurangi stok (teruji 24 ke 22), riwayat per VIN.
* Notifikasi via queue: WA (driver log sampai kredensial Fonnte/Wablas ada) dan email untuk SPK dibuat, bukti diterima/ditolak, Deal, Expired, test drive konfirmasi, servis konfirmasi/selesai, reminder bayar H-6 jam dan servis H-1 (keduanya teruji masuk antrean dan terkirim via worker).
* Promo berperiode (expired otomatis hilang) + banner upload, CMS halaman/berita, halaman cabang + Maps, banner promo di home.

### M4: Invoice, laporan, hardening (hijau)

* Invoice/kuitansi PDF otomatis saat Deal (DomPDF, teruji unduh 200 application/pdf) + upload BAST serah terima.
* Dashboard per peran (antrean, leads, servis, stok) + 5 laporan (penjualan, leads, stok aging, servis, komisi) + export Excel (teruji unduh xlsx).
* Audit log verifikasi SPK, upload BAST, dan perubahan harga (teruji: OTR 255 juta ke 254 juta tercatat).
* Proteksi: role middleware per grup (sales kena 403 di Laporan, tamu kena 302 di semua halaman pesan), throttle SPK/upload, upload whitelist JPG/PNG/PDF 2 MB, storage private untuk KTP/bukti.
* Panduan admin diserahkan (PANDUAN-ADMIN.md) + backup manual teruji restore (36 tabel).

## 3. Kesesuaian per Modul PRD

| Modul PRD | Status |
|---|---|
| 1 Katalog | Sesuai, plus foto dan badge stok |
| 2 Stok VIN | Sesuai, plus index dan lock konkuren |
| 3 SPK + BAST | Sesuai |
| 4 Simulasi | Sesuai, plus tersimpan ke leads |
| 5 Master leasing + CRUD | Sesuai |
| 6 Trade-in | Sesuai |
| 7 Test drive | Sesuai, plus daftar admin |
| 8 Servis + reminder | Sesuai |
| 9 Sparepart | Melebihi: order beneran (SPO) dengan cadang dan kembalikan stok, bukan sekadar pesan |
| 10 CRM leads | Sesuai |
| 11 Promo/CMS | Sesuai kecuali testimoni (sengaja kosong, anti data palsu) |
| 12 Rekening | Sesuai |
| 13 Invoice PDF | Sesuai |
| 14 WA/email queue | Sesuai fungsi, driver log (kredensial gateway tugas pemilik) |
| 15 Dashboard/laporan/export | Sesuai, plus dashboard per peran |
| 16 Audit log | Sesuai |
| Auth 7 peran | Sesuai, plus halaman Users khusus superadmin |
| Master cabang/brand/model/varian/warna | Melebihi: CRUD admin lengkap (PRD hanya menyebut seeder) |

## 4. Bukti UAT (7 skenario PRD Pasal 15)

1. Katalog sampai SPK MenungguBayar: hijau (SPK-2026-0001 terbit + instruksi + booking fee).
2. Upload ke MenungguVerifikasi, Terima/Tolak: hijau.
3. Deal terbitkan invoice PDF + unit Terjual: hijau (INV-2026-0001, Rp 243.000.000 cocok harga unit).
4. Konkuren 2 SPK satu VIN: hijau (kedua 422).
5. Expire otomatis + VIN kembali Tersedia: hijau.
6. Laporan per cabang/periode: hijau (5 laporan + export).
7. Backup-restore + panduan: hijau.

## 5. Data Awal dan Akun Demo

* 32 brand, 239 model, 328 varian (10 per brand), 582 unit, 8 user, 7 role.
* Superadmin: admin@ayotonippon.local / password. Staf @ayotonippon.com (Raihan, Dinar, Fauzan sales; Joko mekanik; Owprabo admin Jakarta; Okwijo admin Bandung), password `password`, ganti setelah login pertama.
* Customer demo: daftar akun baru lewat halaman Daftar.

## 6. Skenario Demo Kelompok (10 menit)

1. Home, katalog filter Honda, detail Brio, Simulasi Kredit (2 menit).
2. Daftar akun baru, Ajukan SPK, Lacak SPK (2 menit).
3. Login Owprabo: antrean verifikasi, Terima, tunjukkan invoice PDF (2 menit).
4. Booking servis, konfirmasi + tambah sparepart, Selesai, stok berkurang (2 menit).
5. Dashboard, Laporan penjualan + export Excel (2 menit).

## 7. Yang Sengaja Belum Final (tugas pemilik/admin)

* Foto 89 model masih "Foto menyusul" (tidak ada di sumber gratis); cara mengaktifkan ada di PANDUAN-ADMIN.md Pasal 7.
* Harga OTR varian baru adalah perkiraan seeder; kunci via menu Price List (tercatat di audit).
* Tarif komisi 1% sementara, perlu ketetapan direksi.
* Trim/varian hasil pecahan (Jaecoo, Denza, VW Tayron dkk) berstatus estimasi.
* Kredensial Fonnte/Wablas dan SMTP produksi.
* Model non-Indonesia sudah dihapus permanen dari katalog (daftar hapus tercatat di seeder sebagai denylist).

## 8. Penutup

Aplikasi siap didemokan dan dinilai. Source di folder `web/`, dokumen acuan di root (PRD, DESIGN, PANDUAN-ADMIN, proposal ini). Perintah jalan: `php artisan serve --port=8000` setelah MariaDB XAMPP menyala.
