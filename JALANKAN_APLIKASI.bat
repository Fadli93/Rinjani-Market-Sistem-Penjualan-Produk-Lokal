@echo off
title Rinjani Market Server
echo ========================================================
echo   APLIKASI RINJANI MARKET - LOCAL SERVER
echo ========================================================
echo.
echo [INFO] Pastikan XAMPP (MySQL) sudah di-START!
echo [INFO] Membuka browser...
echo.

start http://localhost:8080

echo [INFO] Server berjalan di http://localhost:8080
echo [INFO] Tekan CTRL+C untuk menghentikan server.
echo.

php -S localhost:8080 -t public
pause