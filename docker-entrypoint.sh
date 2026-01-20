#!/bin/bash

# -----------------------------------------------------------------------------
# RAILWAY VOLUME FIX: Re-create storage structure if hidden by volume mount
# -----------------------------------------------------------------------------
echo "Ensuring storage directories exist..."
mkdir -p /app/storage/framework/{sessions,views,cache}
mkdir -p /app/storage/logs
mkdir -p /app/bootstrap/cache
mkdir -p /app/storage/app/public/thumbnails

# Fix permissions for the storage directory (critical for volume mounts)
echo "Fixing storage permissions..."
chmod -R 777 /app/storage /app/bootstrap/cache
# -----------------------------------------------------------------------------

# Clear Laravel config so it reads Railway env vars
php artisan config:clear

# Update Nginx port with Railway's dynamic $PORT
if [ -z "$PORT" ]; then
  PORT=80
fi
sed -i "s/PORT_PLACEHOLDER/$PORT/g" /etc/nginx/http.d/default.conf

# Create the symbolic link for public storage
echo "Creating storage symlink..."
php artisan storage:link

# Clear any development caches
php artisan optimize:clear

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed --force

# -----------------------------------------------------------------------------
# FINAL PERMISSION FIX: Ensure www-data owns everything created by root above
# -----------------------------------------------------------------------------
echo "Finalizing permissions for www-data..."
chown -R www-data:www-data /app/storage /app/bootstrap/cache
chmod -R 775 /app/storage /app/bootstrap/cache

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
