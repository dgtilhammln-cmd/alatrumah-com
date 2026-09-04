@echo off
setlocal

echo ==========================================
echo        Mulai Proses Deployment
echo ==========================================
echo.

:: Meminta pesan commit dari user
set /p commit_msg="Masukkan pesan commit (tekan Enter untuk 'Update otomatis'): "
if "%commit_msg%"=="" set commit_msg=Update otomatis

echo.
echo [1/3] Menambahkan dan commit perubahan ke Git...
git add .
git commit -m "%commit_msg%"

echo.
echo [2/3] Push ke GitHub...
:: Pastikan branch Anda bernama 'main' atau 'master'. Sesuaikan jika perlu.
git push origin main

echo.
echo [3/3] Pull terbaru di server Hostinger...
:: CATATAN: Sesuaikan path 'domains/alatrumah.com' dengan path asli direktori project Anda di Hostinger.
:: Jika project ada di folder utama domain, biasanya path-nya adalah 'domains/alatrumah.com'
ssh -p 65002 u947770498@82.180.169.175 "cd domains/alatrumah.com && git pull origin main"

echo.
echo ==========================================
echo           Deployment Selesai!
echo ==========================================
pause
