# Panduan Admin: Web App Ayoto Nippon v1.0

## 1. Membuka aplikasi

* Dev: nyalakan MariaDB XAMPP, lalu dari folder `web` jalankan `php artisan serve --port=8000`. Buka `http://127.0.0.1:8000`.
* Login superadmin awal: `admin@ayotonippon.local` / `password`. Ganti password setelah login pertama (menu nama, Profile).

## 2. Peran dan batas akses

* superadmin, pimpinan: semua menu termasuk Laporan.
* admin-cabang: verifikasi SPK, leads, stok, harga, rekening, trade-in, sparepart, promo, konten, servis, laporan.
* sales: verifikasi SPK, leads, test drive, stok. Tidak bisa membuka Laporan (403).
* service-advisor, mekanik: hanya menu Servis.
* Menu yang tidak sesuai peran otomatis ditolak (403) atau disembunyikan.

## 3. Alur harian

1. Buka Verifikasi untuk SPK MenungguVerifikasi. Periksa bukti, klik Terima (Deal, unit Terjual, invoice PDF terbit) atau Tolak (alasan wajib; pilih beri deadline baru atau batalkan).
2. Buka Leads untuk follow-up. Tetapkan sales, catat hasil hubungi, atur status dan pengingat.
3. Buka Servis untuk booking Menunggu. Konfirmasi beserta estimasi dan mekanik. Mekanik tambah rincian pekerjaan dan sparepart, lalu tandai Selesai (stok sparepart berkurang otomatis).
4. Trade-in: gerakkan status Diajukan, Inspeksi, Ditawar (isi harga), Deal atau Ditolak.

## 4. Aturan penting

* SPK yang tidak dibayar sampai deadline otomatis Expired tiap jam dan unit dilepas. Perintah: `php artisan spk:expire` (terjadwal tiap jam).
* Reminder bayar H-6 jam dan servis H-1 dikirim tiap jam. Perintah: `php artisan notify:reminders` (terjadwal tiap jam).
* Antrean notifikasi diproses worker: `php artisan queue:work`. Tanpa worker, WA dan email hanya menumpuk di tabel jobs.
* Satu VIN hanya untuk satu SPK aktif. Sistem menolak SPK kedua (422).
* Upload KTP, bukti, BAST: JPG/PNG/PDF maks 2 MB, tersimpan di storage private (`storage/app`).
* Invoice PDF terbit otomatis saat Deal dan bisa diunduh di halaman Lacak SPK (khusus peran staf) atau menu verifikasi.
* BAST diunggah admin di halaman Lacak SPK setelah Deal.
* Perubahan harga tercatat di audit log beserta nilai lama dan baru. Tarif komisi laporan 1% masih sementara, perlu ketetapan direksi.

## 5. Backup

* Dump: `"C:\xampp\mysql\bin\mysqldump.exe" -u root ayoto_nippon --result-file="backups\ayoto_nippon_TANGGAL.sql"`.
* Restore uji: buat database `ayoto_restore`, import file dump, hitung tabel dan orders untuk memastikan sama, lalu hapus database uji.
* Jadwalkan dump harian di server produksi (cron atau Task Scheduler).

## 6. Laporan

* Menu Laporan (pimpinan, superadmin, admin-cabang): penjualan, leads, stok aging, servis, komisi. Filter tanggal, export Excel per jenis.

## 7. Foto unit dan produk tampil

* Produk tanpa foto otomatis disembunyikan dari katalog (tidak terhapus).
* Mengaktifkan lagi: buka menu Stok, isi kolom foto untuk unitnya (path file di `web/public/images/`), lalu jalankan `php artisan variant:sync-aktif` dari folder `web`.
* Perintah itu juga menonaktifkan produk yang fotonya dikosongkan.
