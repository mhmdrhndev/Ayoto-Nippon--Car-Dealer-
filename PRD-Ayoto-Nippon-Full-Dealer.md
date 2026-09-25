# PRD — Web App Dealer Mobil PT Ayoto Nippon
**Versi:** 1.0 Final
**Tanggal:** 23 September 2026
**Stack:** PHP + Laravel 11 + MySQL 8 + Blade + Livewire/Alpine + Tailwind CSS
**Skema bayar:** Transfer manual + upload bukti + verifikasi admin (tanpa payment gateway)
**Cakupan:** Full Dealer System, multi-cabang sejak awal

---

## 1. Ringkasan Eksekutif

Web app untuk penjualan dan after-sales dealer mobil PT Ayoto Nippon: katalog online, stok unit per VIN per cabang, SPK/pemesanan online, simulasi kredit, trade-in (tukar tambah), booking test drive, booking servis + reminder, katalog sparepart, CRM leads, promo/CMS, dashboard dan laporan.

Tujuan bisnis:
1. Menaikkan leads online yang tercatat dan bisa di-follow-up.
2. Merapikan stok (tidak ada double-book untuk VIN yang sama).
3. Mempercepat proses SPK dengan alur status yang jelas.
4. Menurunkan no-show servis lewat reminder H-1.

## 2. Tujuan & Indikator Keberhasilan

| Tujuan | Indikator | Target |
|---|---|---|
| Leads tercatat | % leads online masuk CRM | 100% pengajuan web masuk leads |
| Stok akurat | Kasus double-book VIN | 0 kasus |
| SPK terkontrol | SPK tanpa kepastian tidak mengunci stok lama | Expire otomatis 1x24 jam |
| Servis terjadwal | Reminder servis terkirim | 100% booking H-1 terkirim WA |

## 3. Stakeholder, Peran & Hak Akses

| Peran | Akses utama |
|---|---|
| Customer (guest/member) | Katalog, simulasi, SPK, upload bukti, lacak SPK, test drive, trade-in, booking servis, riwayat |
| Sales | Leads + follow-up, validasi awal SPK, konfirmasi test drive |
| Admin Cabang | Stok unit, harga, rekening bank, promo cabang, jadwal servis, verifikasi bukti bayar |
| Service Advisor (SA) | Estimasi servis, konfirmasi booking, update status |
| Mekanik | Update pengerjaan servis |
| Pimpinan | Laporan semua cabang, data penjualan, konversi, stok |
| Superadmin | Semua + manajemen user, role, cabang, pengaturan |

Implementasi: Laravel Breeze/Jetstream + Spatie Permission. Data dilingkupi per cabang kecuali pimpinan/superadmin.

## 4. Ruang Lingkup

### 4.1 In Scope (dibangun)
1. Katalog: brand > model > varian > warna + galeri, spesifikasi, harga OTR per cabang, status stok.
2. Stok unit per VIN (tersedia / dipesan / terjual), harga, foto, cabang, tahun rakit.
3. SPK online + instruksi transfer + upload bukti + verifikasi admin + timeline status + BAST.
4. Simulasi kredit (DP, tenor, leasing) yang tersimpan sebagai leads.
5. Master leasing partner.
6. Trade-in: pengajuan > inspeksi > penawaran > deal/tolak, bisa ditautkan ke SPK.
7. Test drive booking + konfirmasi sales.
8. Servis: booking (tanggal, keluhan, KM, nopol, VIN), estimasi SA, pengerjaan mekanik, status real-time, reminder H-1, riwayat per VIN.
9. Sparepart: katalog, stok per cabang, pemesanan.
10. CRM leads: sumber (Web/WA/Showroom), assign sales, pipeline Baru-Dihubungi-TestDrive-SPK-Deal-Batal, log follow-up.
11. Promo + CMS: banner home, promo per cabang + periode, berita, testimoni, halaman cabang + Google Maps.
12. Master rekening bank per cabang.
13. Invoice/kuitansi PDF setelah verifikasi diterima.
14. Notifikasi WA (Fonnte/Wablas) + email via queue.
15. Dashboard + laporan (penjualan, leads, stok aging, servis, komisi) + export Excel.
16. Audit log (terutama verifikasi SPK dan perubahan harga).

### 4.2 Out of Scope
- Payment gateway otomatis (VA/QRIS/callback Midtrans/Xendit).
- Aplikasi mobile native.
- ERP akuntansi penuh.
- Integrasi core-system leasing (cukup master + simulasi manual).

## 5. Asumsi & Keputusan Disepakati

- Multi-cabang sejak MVP.
- Bahasa Indonesia, mata uang IDR, timezone Asia/Jakarta.
- Booking fee flat per cabang (configurable di pengaturan).
- Deadline bayar SPK 1x24 jam, dieksekusi scheduler tiap jam.
- File bukti: JPG/PNG/PDF, maks 2 MB.
- 1 VIN hanya boleh punya 1 SPK aktif (MenungguBayar / MenungguVerifikasi).

## 6. Alur Utama (User Journey)

### 6.1 Beli mobil
1. Customer buka katalog > filter > detail mobil.
2. Simulasi kredit (opsional) > tersimpan ke leads.
3. Ajukan SPK: pilih unit, isi data diri, upload KTP/KK, pilih metode Cash/Kredit/TradeIn.
4. Sistem terbitkan Nomor SPK + instruksi transfer (bank cabang + nominal + deadline).
5. Customer transfer manual lalu upload bukti di halaman Lacak SPK.
6. Admin/Sales verifikasi Terima/Tolak + alasan.
7. Diterima: SPK Deal, unit jadi Terjual, invoice/kuitansi PDF terbit, WA notifikasi.
8. Ditolak/expired: VIN dilepas ke Tersedia, WA alasan, customer bisa ajukan ulang.
9. Pelunasan sisa offline di dealer + upload BAST serah terima.

### 6.2 Test drive
Pengajuan (pilih jadwal + cabang) > Menunggu > Dikonfirmasi sales > Hadir/Batal.

### 6.3 Servis
Booking (nopol, VIN, KM, keluhan, jadwal) > Dikonfirmasi SA + estimasi > Dikerjakan mekanik (detail pekerjaan + sparepart) > Selesai > WA ambil unit + riwayat tersimpan.

### 6.4 Trade-in
Diajukan (merk, tipe, tahun, KM, foto) > Inspeksi > Ditawar > Deal/Ditolak. Bisa ditautkan ke SPK mobil baru.

## 7. Kebutuhan Fungsional Detail

### F1. Master & katalog
- CRUD brand, model, varian, warna, unit, price list, rekening, leasing, mekanik.
- Filter: brand, transmisi (MT/AT/CVT), BBM, rentang harga, cabang. Pencarian nama. Slug SEO.
- Acceptance: unit berstatus Dipesan/Terjual tidak bisa dipilih untuk SPK baru.

### F2. Simulasi kredit
- Input: unit/varian, DP (Rp + %), tenor, leasing.
- Output: estimasi angsuran. Tombol "Ajukan SPK" dan "Minta dihubungi sales".
- Acceptance: hasil simulasi tersimpan dan terlihat di CRM.

### F3. SPK
- Nomor otomatis `SPK-YYYY-NNNN` dalam DB transaction + lock.
- Wajib: nama, NIK 16 digit, telp 10-15 digit, alamat, KTP. Kredit wajib leasing + tenor valid.
- Timeline status terlihat customer dan admin.
- Acceptance: dari katalog sampai SPK MenungguBayar + WA instruksi terkirim.

### F4. Upload bukti & verifikasi
- Upload hanya saat status MenungguBayar. Setelah upload jadi MenungguVerifikasi.
- Admin: antrean verifikasi, preview bukti, Terima/Tolak + alasan wajib saat tolak.
- Terima: Deal + unit Terjual + invoice. Tolak: kembali MenungguBayar (deadline baru) atau Batal + lepas VIN.
- Audit: verified_by, verified_at tercatat.
- Acceptance: tidak ada SPK Deal tanpa verifikasi admin.

### F5. CRM leads
- Otomatis terbentuk dari simulasi/SPK/test drive/trade-in/minta dihubungi.
- Pipeline: Baru > Dihubungi > TestDrive > SPK > Deal / Batal. Assign sales, log follow-up + next reminder.
- Acceptance: konversi per sales bisa dilaporkan.

### F6. Test drive, servis, sparepart
- Slot jadwal per cabang agar tidak bentrok. Estimasi SA bisa diedit. Stok sparepart berkurang saat servis selesai.
- Acceptance: reminder H-1 terkirim; riwayat servis bisa dicari per VIN/nopol.

### F7. Promo & CMS
- Promo punya periode + cabang + banner. Expired otomatis nonaktif.
- Konten: banner home, tentang kami, cabang, berita, testimoni.

### F8. Laporan
- Penjualan (periode/cabang/sales), konversi leads, stok aging (unit lama belum terjual), servis (booking/selesai/pendapatan), komisi sales dari SPK Deal. Export Excel.

## 8. Kebutuhan Non-Fungsional

- Responsive mobile-first (Tailwind). Target loading katalog < 2,5 detik.
- Keamanan: validasi server-side, Eloquent ORM (anti SQLi), CSRF, XSS escaping Blade, rate-limit login dan SPK, whitelist upload, storage private untuk KTP/bukti, role ketat untuk harga/diskon/verifikasi.
- Backup DB harian + uji restore. Audit log untuk verifikasi dan perubahan harga.
- SEO dasar: slug, meta title/deskripsi katalog.

## 9. Arsitektur & Tech Stack

- Laravel 11 + MySQL 8, Blade + Livewire/Alpine + Tailwind.
- Sanctum (kesiapan API mobile di masa depan). Queue database/Redis untuk WA/email.
- Storage lokal/S3 untuk foto, KTP, bukti. DomPDF untuk SPK/invoice/kuitansi. Laravel-Excel untuk laporan.
- Scheduler: expire SPK tiap jam + kirim reminder H-6 jam bayar dan H-1 servis.
- Deploy: VPS Nginx + PHP 8.2 + SSL + supervisor untuk queue + cron scheduler.

## 10. Data Model (daftar tabel final)

`branches, bank_accounts, users(+branch_id,telp), customers, brands, car_models, variants, colors, units(VIN unique,status), price_lists, leasing_partners, leads, lead_followups, test_drives, orders(no_spk unique,status,deadline_at,bukti_path,verified_by/at), trade_ins, service_bookings(no_svc unique), service_details, spareparts, promos, invoices, contents, activity_logs`

Index wajib: `units(status,branch_id)`, `orders(status,deadline_at)`, `leads(status,sales_id)`.

Urutan migrate: branches > bank_accounts > users > customers > brands > car_models > variants > colors > units > price_lists > leasing_partners > leads > lead_followups > test_drives > orders > trade_ins > service_bookings > service_details > spareparts > promos > invoices > contents > activity_logs.

Seeder awal: roles (superadmin, pimpinan, admin-cabang, sales, service-advisor, mekanik, customer), 1 superadmin, 2 cabang + rekening contoh, 2 brand + model + varian + warna, 3 leasing, promo contoh.

### Detail kolom inti

**branches:** id, kode unique, nama, alamat, telp, maps_url, aktif(boolean)
**bank_accounts:** id, branch_id FK, bank, no_rek, atas_nama, aktif
**customers:** id, user_id nullable FK, nama, nik(16), telp, alamat, ktp_path, kk_path
**units:** id, vin unique, variant_id FK, color_id FK, branch_id FK, status enum(Tersedia,Dipesan,Terjual) default Tersedia, tahun_rakit, harga bigint, foto_utama
**price_lists:** id, variant_id FK, branch_id FK, otr bigint, bbn bigint, diskon bigint, berlaku_dari/sampai, unique(variant,branch)
**leasing_partners:** id, nama, telp, dp_min_persen, tenor_list(string ex 12,24,36,48), bunga_dasar, aktif
**leads:** id, customer_id FK, sales_id nullable FK users, sumber enum(Web,WA,Showroom), status enum(Baru,Dihubungi,TestDrive,SPK,Deal,Batal), kebutuhan_text, followup_at nullable
**orders:** id, no_spk unique, customer_id FK, unit_id FK, branch_id FK, metode enum(Cash,Kredit,TradeIn), leasing_id nullable FK, dp_rencana bigint, tenor int nullable, angsuran_estimasi bigint nullable, booking_fee bigint, status enum(MenungguBayar,MenungguVerifikasi,Deal,Ditolak,Expired,Batal), deadline_at datetime, bukti_path nullable, verified_by nullable FK users, verified_at nullable, tolak_alasan nullable
**trade_ins:** id, customer_id FK, order_id nullable FK, merk_tipe, tahun, km, foto_paths json, status enum(Diajukan,Inspeksi,Ditawar,Deal,Ditolak), harga_penawaran nullable bigint
**service_bookings:** id, no_svc unique, customer_id FK, branch_id FK, nopol, vin, km, keluhan text, jadwal datetime, status enum(Menunggu,Dikonfirmasi,Dikerjakan,Selesai,Batal), estimasi_biaya bigint, mekanik_id nullable FK users
**service_details:** id, service_booking_id FK, jenis enum(Pekerjaan,Sparepart), deskripsi, qty, harga_satuan bigint, subtotal bigint

## 11. Routes / Sitemap

Publik: `/ /katalog /mobil/{slug} /simulasi-kredit /promo /trade-in /test-drive /servis-booking /lacak-spk /cabang`
Customer (auth): `spk/create, spk/{no_spk}, spk/{no_spk}/upload-bukti`
Admin (prefix `admin` + auth + role): `dashboard, units, price-lists, bank-accounts, orders + verify, leads + followup, test-drives, trade-ins, services, spareparts, promos, contents, laporan/{penjualan,leads,stok,servis} + export, users + roles`

## 12. Integrasi & Notifikasi

- WA gateway (Fonnte/Wablas) + SMTP email, semua via queue (Jobs: SendWaJob, SendMailJob).
- Template: SPK dibuat (rek + deadline), reminder bayar H-6 jam, bukti diterima/ditolak, SPK expired, test drive konfirmasi, servis H-1/selesai.

## 13. Milestone

- M1 (2-3 minggu): auth + role, master mobil/cabang/rekening, katalog publik.
- M2 (3 minggu): stok, SPK manual + verifikasi, leads, test drive, simulasi kredit.
- M3 (3 minggu): trade-in, servis, sparepart, notifikasi WA/email, promo/CMS.
- M4 (2 minggu): dashboard/laporan/export, hardening, UAT, deploy.
- Total estimasi: 10-12 minggu untuk tim 2-3 developer (asumsi desain memakai template admin siap pakai).

## 14. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| Verifikasi manual lambat, antrean menumpuk | SLA internal + halaman antrean + notif WA ke admin |
| Bukti transfer palsu | Preview wajib, audit verified_by/at, batas upload ulang |
| Stok terkunci terlalu lama oleh SPK PHP | Expiry otomatis + reminder + lepas VIN |
| Data KTP/bukti bocor | Storage private + akses berbasis role |
| Scope membesar | Kunci PRD v1.0 ini; perubahan masuk change request |

## 15. Kriteria Penerimaan Rilis (UAT)

1. Customer bisa dari katalog sampai SPK MenungguBayar dan menerima WA instruksi.
2. Upload bukti mengubah status ke MenungguVerifikasi; admin bisa Terima/Tolak.
3. SPK Deal menerbitkan invoice PDF dan mengunci unit jadi Terjual.
4. Uji konkuren: 2 SPK untuk VIN sama tidak bisa dua-duanya aktif.
5. SPK melewati deadline otomatis Expired dan VIN kembali Tersedia.
6. Pimpinan bisa melihat laporan penjualan, leads, stok per cabang per periode.
7. Backup dan restore DB teruji. Panduan admin diserahkan.

## 16. Langkah Eksekusi Berikutnya

1. `composer create-project laravel/laravel ayoto-nippon`
2. Pasang Breeze, Spatie Permission, Tailwind.
3. Buat migrate sesuai Pasal 10 berurutan + seeder Pasal 10.
4. Kerjakan per milestone M1 > M2 > M3 > M4 dengan demo tiap milestone.

---
*Dokumen ini adalah acuan tunggal (source of truth) v1.0. Perubahan setelah ini dicatat sebagai change request.*
