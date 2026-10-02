@echo off
cd /d "D:\Kampus\Semester 7\Pemrograman Web II\Ayoto Nippon (Car Dealer)\web"
:loop
"C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe" artisan schedule:run
timeout /t 60 /nobreak >nul
goto loop
