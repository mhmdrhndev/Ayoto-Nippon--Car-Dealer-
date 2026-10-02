# Checklist Demo Kampus, Ayoto Nippon

Demo: laptop sendiri + proyektor. Internet: hotspot HP. Buka aplikasi via `http://127.0.0.1:8000`.

## 1. Nyalakan service (±5 menit)

- [ ] Buka Laragon, pastikan MySQL jalan.
- [ ] Terminal 1 (biarkan terbuka, minimize):
  ```
  php artisan serve --host=0.0.0.0 --port=8000
  ```
- [ ] Terminal 2 (biarkan terbuka, minimize):
  ```
  php artisan queue:work --sleep=3 --tries=3
  ```
- [ ] Cek 1 worker hidup:
  ```
  Get-CimInstance Win32_Process -Filter "Name = 'php.exe'" | Where-Object { $_.CommandLine -match 'queue:work' }
  ```
- [ ] Catatan: bila perintah `php` tidak dikenal, ganti dengan `C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe`. Semua perintah dijalankan dari folder `web`.

## 2. Kunci alamat (1 menit)

- [ ] `.env`: `APP_URL=http://127.0.0.1:8000`
- [ ] `php artisan config:clear`
- [ ] `php artisan queue:restart`, tutup terminal worker lama, nyalakan ulang (langkah 1).

## 3. Internet + email (3 menit)

- [ ] Nyalakan hotspot HP, sambungkan laptop.
- [ ] Test 1 email: halaman forgot-password, minta link ke email sendiri, pastikan masuk inbox (cek Spam juga).

## 4. Siapkan panggung (5 menit)

- [ ] Login 2 akun di 2 profil browser berbeda: customer (pengaju) dan admin (verifikator).
- [ ] Buka tab: Katalog, Lacak SPK, Antrean Verifikasi.
- [ ] Proyektor mirror, zoom browser 110-125%.

## 5. Alur demo (±10 menit)

- [ ] Katalog, Lihat Detail (spek lengkap + warna tersedia), Ajukan SPK.
- [ ] Tunjukkan email instruksi transfer masuk (ada link lacak).
- [ ] Upload bukti, tunjukkan email "bukti diterima" masuk.
- [ ] Pindah akun admin, verifikasi Deal, tunjukkan email Deal + invoice PDF.
- [ ] Riwayat verifikasi, tombol Chat pembeli (pesan konfirmasi terisi).
- [ ] Leads, klik ID, Chat WA follow-up. Tutup di laporan.

## 6. Jika apes

- [ ] Hotspot mati: lanjut offline. Email menumpuk di tabel `jobs`, tunjukkan sebagai bukti alur antrean.
- [ ] Error tak terduga: jangan tampilkan stack trace, kembali ke tab yang sudah terbuka.
- [ ] Jangan tampilkan isi `.env` di proyektor (ada App Password).

## 7. Yang tidak perlu dilakukan saat demo

- [ ] Reset database (sudah H-1), edit kode, `migrate`, buka XAMPP, daftar akun baru.
