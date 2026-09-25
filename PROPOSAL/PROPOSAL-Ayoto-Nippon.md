# Proposal Pembangunan Web App Dealer Mobil PT Ayoto Nippon

**Dokumen:** Proposal Teknis dan Biaya
**Acuan:** PRD v1.0 Final, 23 September 2026 (PRD-Ayoto-Nippon-Full-Dealer.md)
**Disusun untuk:** Direksi PT Ayoto Nippon
**Tanggal proposal:** 23 September 2026
**Masa berlaku:** 30 hari kalender
**Revisi 1, 24 September 2026:** alur di bawah diselaraskan dengan aplikasi yang sudah dibangun (daftar wajib login, pilih cabang di SPK, order sparepart SPO, invoice terlampir di email, chat WA dua arah).

---

## 1. Pemahaman Kebutuhan

PT Ayoto Nippon membutuhkan satu sistem web untuk menggantikan proses manual yang saat ini tersebar di katalog, WhatsApp, dan pencatatan stok.

Empat masalah utama yang disepakati di PRD:

1. Leads online tidak tercatat rapi, sehingga sulit di follow-up.
2. Risiko double-book untuk VIN yang sama antar cabang atau antar sales.
3. Proses SPK tidak punya status yang jelas dari pengajuan sampai deal.
4. No-show servis karena tidak ada reminder terstruktur.

Sistem yang diusulkan menjawab keempat hal tersebut dalam satu aplikasi: katalog publik, stok per VIN per cabang, SPK online dengan verifikasi, CRM leads, test drive, trade-in, booking servis, sparepart, promo/CMS, dan laporan.

## 2. Tujuan dan Indikator Keberhasilan

| Tujuan | Indikator | Target sesuai PRD |
|---|---|---|
| Leads tercatat | Semua pengajuan web masuk CRM | 100% |
| Stok akurat | Kasus double-book VIN | 0 kasus |
| SPK terkontrol | SPK tanpa kepastian tidak mengunci stok lama | Expire otomatis 1x24 jam |
| Servis terjadwal | Reminder servis H-1 terkirim via WA | 100% booking |

Proposal ini dinyatakan berhasil jika tujuh kriteria UAT pada PRD Pasal 15 lolos semua, termasuk uji konkuren VIN dan uji expire otomatis.

## 3. Ruang Lingkup Pekerjaan

### 3.1 Yang dikerjakan (In Scope)

Merujuk PRD Pasal 4.1, lingkup mencakup 16 modul:

1. Katalog: brand, model, varian, warna, galeri, spesifikasi, harga OTR per cabang, status stok. Terbuka publik tanpa login.
2. Stok unit per VIN dengan status Tersedia, Dipesan, Terjual.
3. SPK online (wajib login): pilih cabang dulu lalu unit, isi data diri, NIK otomatis dikaitkan ke akun login, nomor otomatis SPK-YYYY-NNNN, upload KTP/KK, instruksi transfer, upload bukti, verifikasi, timeline, BAST. Bukti milik akun lain ditolak dengan pesan jelas.
4. Simulasi kredit yang tersimpan sebagai leads.
5. Master leasing partner.
6. Trade-in (wajib login): pengajuan, inspeksi, penawaran, deal/tolak, tautan ke SPK.
7. Booking test drive (wajib login) dan konfirmasi sales.
8. Booking servis (wajib login): jadwal, estimasi SA, pengerjaan mekanik, status real-time, reminder H-1, riwayat per VIN.
9. Katalog dan stok sparepart per cabang plus order sparepart sendiri (nomor SPO): checkout, transfer, upload bukti, konfirmasi admin, stok dicadangkan dan dikembalikan saat batal.
10. CRM leads: sumber Web/WA/Showroom, assign sales, pipeline Baru sampai Deal/Batal, log follow-up.
11. Promo dan CMS: banner (bisa upload), promo per cabang berperiode, berita, halaman cabang plus Google Maps. Tanpa testimoni fiktif.
12. Master rekening bank per cabang.
13. Invoice dan kuitansi PDF otomatis saat Deal, dilampirkan di email customer, bisa diunduh mandiri oleh pemilik SPK, plus tombol chat WA dua arah (admin ke customer, customer ke cabang).
14. Notifikasi WA via antrean (driver log sampai kredensial Fonnte/Wablas ada; tombol chat WA langsung berfungsi) dan email via queue.
15. Dashboard per peran dan laporan plus export Excel: penjualan, leads, stok aging, servis, komisi.
16. Audit log untuk verifikasi SPK, upload BAST, dan perubahan harga.

Hak akses tujuh peran: customer, sales, admin cabang, service advisor, mekanik, pimpinan, superadmin. Implementasi memakai Laravel Breeze/Jetstream dan Spatie Permission, dengan lingkup data per cabang kecuali pimpinan dan superadmin.

### 3.2 Yang tidak termasuk (Out of Scope)

1. Payment gateway otomatis (VA, QRIS, callback Midtrans/Xendit).
2. Aplikasi mobile native. Sistem disiapkan API via Sanctum untuk kebutuhan tersebut di masa depan.
3. Modul akuntansi penuh atau ERP.
4. Integrasi core-system leasing.

Perubahan di luar daftar 3.1 dicatat sebagai change request terpisah.

## 4. Solusi Teknis

Stack sesuai PRD Pasal 9, tanpa perubahan:

* Backend: Laravel 11, PHP 8.2, MySQL 8
* Frontend: Blade, Livewire/Alpine, Tailwind CSS, mobile-first responsive
* Auth dan role: Breeze/Jetstream, Spatie Permission, Sanctum
* Queue: database/Redis untuk WA dan email (Jobs: SendWaJob, SendMailJob)
* File: storage lokal/S3 untuk foto, KTP, bukti. KTP dan bukti di storage private dengan akses berbasis role.
* Dokumen: DomPDF untuk SPK/invoice/kuitansi, Laravel-Excel untuk laporan
* Scheduler: expire SPK tiap jam, reminder bayar H-6 jam, reminder servis H-1
* Deploy: VPS Nginx, SSL, supervisor untuk queue, cron scheduler, backup DB harian

Keputusan teknis yang dikunci dari PRD Pasal 5:

* Multi-cabang sejak awal, Bahasa Indonesia, IDR, Asia/Jakarta
* Booking fee flat per cabang, configurable di pengaturan
* Deadline bayar SPK 1x24 jam
* Bukti: JPG/PNG/PDF, maks 2 MB
* Satu VIN hanya boleh punya satu SPK aktif (MenungguBayar atau MenungguVerifikasi), ditegakkan di DB transaction plus lock

## 5. Tahapan, Jadwal, dan Deliverable

Total durasi 10 sampai 12 minggu untuk tim 2 sampai 3 developer, dengan asumsi memakai template admin siap pakai. Demo dilakukan di akhir setiap milestone.

### M1, minggu 1-3: Fondasi dan katalog

* Auth, role, manajemen user, cabang
* Master mobil, cabang, rekening, price list
* Katalog publik plus filter dan slug SEO
* Deliverable: aplikasi staging bisa login per peran, katalog bisa dibuka publik

### M2, minggu 4-6: Stok, SPK, leads

* Stok per VIN, validasi anti double-book
* SPK manual sampai MenungguBayar, upload bukti, antrean verifikasi
* Simulasi kredit, test drive, CRM leads tahap awal
* Deliverable: alur katalog sampai SPK MenungguBayar plus WA instruksi berjalan

### M3, minggu 7-9: After-sales dan notifikasi

* Trade-in, booking servis, sparepart
* Notifikasi WA dan email via queue
* Promo dan CMS
* Deliverable: booking servis dengan reminder H-1, trade-in bisa ditautkan ke SPK

### M4, minggu 10-12: Laporan, hardening, deploy

* Dashboard dan lima laporan plus export Excel
* Hardening keamanan, audit log, backup dan uji restore
* UAT, panduan admin, deploy produksi
* Deliverable: rilis v1.0 siap UAT sesuai tujuh kriteria PRD Pasal 15

Jadwal rinci per minggu disepakati ulang saat kickoff setelah data master cabang dan rekening diterima.

## 6. Kriteria Penerimaan (UAT)

UAT memakai tujuh skenario dari PRD Pasal 15:

1. Katalog sampai SPK MenungguBayar dan WA instruksi diterima.
2. Upload bukti mengubah status ke MenungguVerifikasi, admin bisa Terima atau Tolak dengan alasan.
3. SPK Deal menerbitkan invoice PDF dan unit menjadi Terjual.
4. Uji konkuren: dua SPK untuk VIN yang sama tidak bisa aktif bersamaan.
5. SPK lewat deadline otomatis Expired dan VIN kembali Tersedia.
6. Pimpinan bisa melihat laporan penjualan, leads, dan stok per cabang per periode.
7. Backup dan restore DB teruji, panduan admin diserahkan.

Serah terima dilakukan setelah semua skenario lolos dan ditandatangani dalam berita acara.

## 7. Estimasi Biaya

Estimasi di bawah ini untuk lingkup penuh Pasal 3.1 dengan durasi 10 sampai 12 minggu. Angka final dikunci setelah workshop kickoff dan review data master.

| Paket | Lingkup | Estimasi |
|---|---|---|
| A. Full Dealer v1.0 (disarankan) | 16 modul, 7 peran, multi-cabang, WA/email, laporan plus export, deploy, panduan | Rp 145.000.000 sampai Rp 185.000.000 |
| B. MVP M1+M2 saja | Fondasi, katalog, stok, SPK, simulasi, leads, test drive. Tanpa trade-in, servis lanjutan, dan laporan komisi. | Rp 75.000.000 sampai Rp 95.000.000 |

Rincian kasar paket A:

| Komponen | Porsi |
|---|---|
| M1 fondasi dan katalog | 20% |
| M2 stok, SPK, leads | 30% |
| M3 trade-in, servis, notifikasi, CMS | 30% |
| M4 laporan, hardening, deploy, dokumentasi | 20% |

Yang sudah termasuk: source code, 1x deploy VPS, template admin, DomPDF dan Excel export, panduan admin, garansi bug 60 hari.

Yang belum termasuk: biaya VPS dan domain, lisensi WA gateway (Fonnte/Wablas) dan SMTP, pengadaan foto unit, input data awal massal di luar seeder PRD Pasal 10, dan change request di luar PRD v1.0.

## 8. Skema Pembayaran

Termin mengikuti milestone agar sejajar dengan demo:

* 20% DP saat kickoff dan PRD dikunci
* 20% saat M1 diterima
* 25% saat M2 diterima
* 25% saat M3 diterima
* 10% pelunasan saat BAST rilis v1.0

Pembayaran per termin maksimal 7 hari kalender setelah berita acara milestone. Keterlambatan data atau keputusan dari pihak Ayoto menggeser jadwal secara proporsional.

## 9. Garansi dan Maintenance

* Garansi bug 60 hari kalender sejak BAST, gratis, untuk defect yang mereplikasi skenario UAT.
* Di luar garansi atau untuk fitur baru, tersedia dua opsi:
  * Retainer bulanan: Rp 6.000.000 sampai Rp 9.000.000 per bulan, mencakup monitoring queue dan scheduler, backup check, update minor, dan SLA respon 1x24 jam hari kerja.
  * Pay-per-change: diestimasi per change request, cocok jika perubahan jarang.
* SLA verifikasi manual dan antrean SPK tetap tanggung jawab operasional internal Ayoto, sistem hanya menyediakan halaman antrean dan notifikasi ke admin.

## 10. Asumsi, Risiko, dan Mitigasi

| Risiko dari PRD | Mitigasi yang kami bangun |
|---|---|
| Antrean verifikasi menumpuk | Halaman antrean verifikasi, notif WA ke admin, pencatatan verified_by dan verified_at |
| Bukti transfer palsu | Preview wajib, batas upload ulang, audit log |
| Stok terkunci terlalu lama | Expire otomatis tiap jam, reminder H-6 jam, VIN dilepas otomatis |
| Data KTP dan bukti bocor | Storage private, akses berbasis role, validasi server-side |
| Scope membesar | PRD v1.0 dikunci, perubahan lewat change request |

Asumsi yang perlu dipenuhi Ayoto sebelum M1: daftar 2 cabang plus rekening, data master brand/model/varian/warna awal, akun WA gateway dan SMTP, serta akses VPS.

## 11. Tim Pelaksana

* 1 project lead merangkap backend Laravel
* 1 sampai 2 developer fullstack (Blade, Livewire, Tailwind)
* 1 QA part-time untuk skenario UAT Pasal 15

Komunikasi: satu grup koordinasi, demo tiap milestone, laporan progres mingguan satu halaman.

## 12. Langkah Selanjutnya

1. Setujui paket A atau B dan kunci PRD v1.0 sebagai acuan tunggal.
2. Tanda tangan SPK kerja dan pembayaran DP 20%.
3. Workshop kickoff 1 hari: validasi cabang, rekening, booking fee, template WA, dan struktur price list.
4. M1 dimulai maksimal 5 hari kerja setelah data master diterima lengkap.

---

*Lampiran acuan: PRD-Ayoto-Nippon-Full-Dealer.md v1.0. Jika ada perbedaan antara proposal ini dan PRD, isi PRD yang berlaku kecuali disepakati tertulis sebagai change request.*
