@echo off
echo ==========================================================
echo FULL DEPLOY SCRIPT (ZIP -^> SCP -^> UNZIP)
echo ==========================================================

set SSH_HOST=46.202.186.86
set SSH_PORT=65002
set SSH_USER=u664715641
set REMOTE_DIR=/home/u664715641/domains/cyclevent.hvmdigital.id
set ZIP_FILE=cyclevent_deploy.zip

echo [1] Membuat file ZIP dari project lokal...
if exist %ZIP_FILE% del %ZIP_FILE%
tar -a -c -f %ZIP_FILE% --exclude=".git" --exclude="node_modules" --exclude="vendor" *

echo [2] Mengunggah ZIP ke Hostinger (Akan diminta password SSH)...
scp -P %SSH_PORT% %ZIP_FILE% %SSH_USER%@%SSH_HOST%:%REMOTE_DIR%/%ZIP_FILE%

echo [3] Ekstrak file di server dan bersihkan cache (Akan diminta password SSH)...
ssh -p %SSH_PORT% %SSH_USER%@%SSH_HOST% "cd %REMOTE_DIR% && unzip -o %ZIP_FILE% && rm %ZIP_FILE% && php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear && chmod -R 775 storage bootstrap/cache && echo Deploy Selesai!"

echo Selesai!
pause
