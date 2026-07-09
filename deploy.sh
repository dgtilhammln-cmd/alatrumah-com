#!/bin/bash
# ══════════════════════════════════════════════════════════
# Deploy Script — CV. Karya Perdana Teknik
# Target: Hostinger VPS  ssh -p 65002 u664715641@46.202.186.86
# ══════════════════════════════════════════════════════════

SSH_HOST="46.202.186.86"
SSH_PORT="65002"
SSH_USER="u664715641"
REMOTE_BASE="/home/u664715641/domains/produsenhoistcranelift.com"
LOCAL_BASE="$(cd "$(dirname "$0")" && pwd)"

echo "🚀 Starting deploy to $SSH_HOST..."
echo ""

# ── 1. Upload changed files via rsync ────────────────────
echo "📦 Syncing files..."
rsync -avz --progress \
  -e "ssh -p $SSH_PORT" \
  --exclude=".git" \
  --exclude="node_modules" \
  --exclude="vendor" \
  --exclude=".env" \
  --exclude="database/database.sqlite" \
  --exclude="storage/logs" \
  --exclude="storage/framework/cache" \
  --exclude="storage/framework/sessions" \
  --exclude="storage/framework/views" \
  "$LOCAL_BASE/" \
  "$SSH_USER@$SSH_HOST:$REMOTE_BASE/"

echo ""
echo "⚙️  Running server-side commands..."

# ── 2. Run artisan commands ────────────────────────────────
ssh -p $SSH_PORT $SSH_USER@$SSH_HOST << 'ENDSSH'
  set -e
  cd /home/u664715641/domains/produsenhoistcranelift.com

  echo "-- Running migrations..."
  php public_html/../artisan migrate --force 2>&1

  echo "-- Clearing caches..."
  php public_html/../artisan config:clear 2>&1
  php public_html/../artisan route:clear 2>&1
  php public_html/../artisan view:clear 2>&1
  php public_html/../artisan cache:clear 2>&1

  echo "-- Optimizing..."
  php public_html/../artisan config:cache 2>&1
  php public_html/../artisan route:cache 2>&1
  php public_html/../artisan view:cache 2>&1

  echo "-- Setting permissions..."
  chmod -R 775 storage bootstrap/cache
  chown -R u664715641:www-data storage bootstrap/cache 2>/dev/null || true

  echo ""
  echo "✅ Deploy complete!"
ENDSSH
