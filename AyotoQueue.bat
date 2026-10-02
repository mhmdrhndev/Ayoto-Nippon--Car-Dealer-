@echo off
cd /d "D:\Kampus\Semester 7\Pemrograman Web II\Ayoto Nippon (Car Dealer)\web"
"C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe" artisan queue:work --sleep=3 --tries=3
