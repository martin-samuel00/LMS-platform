#!/bin/sh
set -e

echo "🚀 Starting LMS Platform on Render Cloud..."

# Storage link
php artisan storage:link || true

# Run database migrations
if [ -n "$DB_HOST" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || true
fi

# Clear and rebuild cache
php artisan optimize:clear
php artisan optimize || true

# Start PHP-FPM daemon
php-fpm -D

# Start Nginx web server
echo "✅ Server online on port 10000!"
exec nginx -g "daemon off;"
