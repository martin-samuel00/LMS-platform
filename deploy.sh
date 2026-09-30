#!/bin/bash
set -e

echo "🚀 Deploying LMS Platform to Production..."

# 1. Put application into maintenance mode
php artisan down --message="Deploying updates. Back online in a moment!" || true

# 2. Pull latest release
git pull origin main

# 3. Install/update composer dependencies (optimized for production)
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Install npm dependencies and build production assets
npm ci || npm install
npm run build

# 5. Run database migrations
php artisan migrate --force

# 6. Clear and cache bootstrap metadata
php artisan optimize:clear
php artisan optimize

# 7. Restart background queues and WebSocket daemons
php artisan queue:restart
sudo supervisorctl restart lms-worker:*
sudo supervisorctl restart lms-reverb:*

# 8. Bring application out of maintenance mode
php artisan up

echo "✅ Production Deployment Completed Successfully!"
