#!/bin/bash

# Update Nginx port with Railway's dynamic $PORT
if [ -z "$PORT" ]; then
  PORT=80
fi
sed -i "s/PORT_PLACEHOLDER/$PORT/g" /etc/nginx/http.d/default.conf

# Clear any development caches
php artisan optimize:clear

# Run migrations
php artisan migrate --force

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g "daemon off;"
