# ==========================================================
# FULL DEPLOY SCRIPT (ZIP -> SCP -> UNZIP)
# ==========================================================

$SSH_HOST = "46.202.186.86"
$SSH_PORT = "65002"
$SSH_USER = "u664715641"
$REMOTE_DIR = "/home/u664715641/domains/cyclevent.hvmdigital.id"
$ZIP_FILE = "cyclevent_deploy.zip"

Write-Host "📦 1. Membuat file ZIP dari project lokal..." -ForegroundColor Cyan
# Hapus zip lama jika ada
if (Test-Path $ZIP_FILE) { Remove-Item $ZIP_FILE -Force }

# Gunakan tar.exe bawaan Windows 10/11 untuk membuat zip, exclude folder berat
& tar.exe -a -c -f $ZIP_FILE --exclude=".git" --exclude="node_modules" --exclude="vendor" *

Write-Host "🚀 2. Mengunggah $ZIP_FILE ke Hostinger (Akan diminta password SSH)..." -ForegroundColor Cyan
& scp -P $SSH_PORT $ZIP_FILE "${SSH_USER}@${SSH_HOST}:${REMOTE_DIR}/$ZIP_FILE"

Write-Host "⚙️  3. Ekstrak file di server dan bersihkan cache (Akan diminta password SSH)..." -ForegroundColor Cyan
$RemoteCommands = @"
cd $REMOTE_DIR
unzip -o $ZIP_FILE
rm $ZIP_FILE
composer install --no-dev --optimize-autoloader
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan config:cache
php artisan migrate --force
chmod -R 775 storage bootstrap/cache
echo '✅ Deploy Selesai!'
"@

& ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $RemoteCommands

Write-Host "🎉 Selesai!" -ForegroundColor Green
