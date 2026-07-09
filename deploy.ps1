# ══════════════════════════════════════════════════════════
# Deploy Script (PowerShell) — CV. Karya Perdana Teknik
# Target: Hostinger  ssh -p 65002 u664715641@46.202.186.86
# Jalankan: .\deploy.ps1  (dari folder project)
# ══════════════════════════════════════════════════════════

$SSH_HOST = "46.202.186.86"
$SSH_PORT = "65002"
$SSH_USER = "u664715641"
$REMOTE_BASE = "/home/u664715641/domains/produsenhoistcranelift.com"
$LOCAL_BASE = $PSScriptRoot

Write-Host "🚀 Starting deploy to $SSH_HOST..." -ForegroundColor Cyan
Write-Host ""

# ── 1. Sync files via rsync / scp ────────────────────────
# Sync file-file yang diubah (views, routes, app, config)
$FilesToSync = @(
    "resources/views/components/wa-button.blade.php",
    "resources/views/components/navbar.blade.php",
    "resources/views/components/footer.blade.php",
    "resources/views/components/order-modal.blade.php",
    "resources/views/admin/leads/index.blade.php",
    "resources/views/admin/leads/show.blade.php",
    "app/Http/Controllers/LeadController.php",
    "app/Http/Controllers/Admin/AdminLeadController.php",
    "app/Models/Lead.php",
    "app/Models/WaSetting.php",
    "routes/web.php"
)

Write-Host "📦 Uploading changed files..." -ForegroundColor Yellow

foreach ($file in $FilesToSync) {
    $localPath  = "$LOCAL_BASE\$($file.Replace('/', '\'))"
    $remotePath = "$REMOTE_BASE/$file"
    $remoteDir  = ($remotePath -split "/")[0..($remotePath.Split("/").Count - 2)] -join "/"

    Write-Host "  → $file"
    # Buat direktori remote jika belum ada, lalu upload
    & ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" "mkdir -p $(Split-Path $remotePath -Parent)" 2>$null
    & scp -P $SSH_PORT $localPath "${SSH_USER}@${SSH_HOST}:${remotePath}"
}

Write-Host ""
Write-Host "⚙️  Running artisan commands on server..." -ForegroundColor Yellow

# ── 2. Run artisan migrate + cache clear ─────────────────
$RemoteCommands = @"
cd /home/u664715641/domains/produsenhoistcranelift.com
echo '--- Migrate ---'
php artisan migrate --force
echo '--- Clear caches ---'
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo '--- Re-cache ---'
php artisan config:cache
php artisan view:cache
echo '--- Permissions ---'
chmod -R 775 storage bootstrap/cache
echo ''
echo 'Deploy done!'
"@

& ssh -p $SSH_PORT "${SSH_USER}@${SSH_HOST}" $RemoteCommands

Write-Host ""
Write-Host "✅ Deploy selesai!" -ForegroundColor Green
