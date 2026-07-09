#!/bin/bash
# ==========================================================
# DEPLOY CYCLE VENT ke Hostinger
# Jalankan file ini dari folder project dengan:
# bash deploy_cyclevent.sh
# ==========================================================

SSH_HOST="46.202.186.86"
SSH_PORT="65002"
SSH_USER="u664715641"
SSH_PASS='#Ilhammaulana23'
REMOTE_DIR="/home/u664715641/domains/cyclevent.hvmdigital.id/public_html"
LOCAL_DIR="$(dirname "$0")"

echo "🚀 Deploying Cycle Vent ke Hostinger..."

# Menggunakan sshpass untuk otomatis input password
if command -v sshpass &> /dev/null; then
    echo "✅ sshpass ditemukan"
    SSHPASS_CMD="sshpass -p '$SSH_PASS'"
else
    echo "⚠️  sshpass tidak ada, gunakan cara manual di bawah"
    echo ""
    echo "=== CARA MANUAL ==="
    echo "Buka Git Bash atau terminal, jalankan:"
    echo ""
    echo "ssh -p $SSH_PORT $SSH_USER@$SSH_HOST"
    echo "# Password: $SSH_PASS"
    echo ""
    echo "# Setelah login, jalankan:"
    echo "cd /home/u664715641/domains/cyclevent.hvmdigital.id"
    echo "git pull origin main"
    echo "php artisan config:clear"
    echo "php artisan route:clear"  
    echo "php artisan view:clear"
    echo "php artisan cache:clear"
    echo "php artisan config:cache"
    echo "chmod -R 775 storage bootstrap/cache"
    echo "echo 'Done!'"
    exit 0
fi
