#!/bin/sh

# Render.com startup script for Laravel application

set -e

echo "Starting Hydration Buddy..."

# Wait for database to be ready
echo "Waiting for database connection..."
for i in $(seq 1 30); do
    if php artisan migrate --force --no-interaction 2>/dev/null; then
        echo "Database connected and migrations completed!"
        break
    fi
    echo "Waiting for database... ($i/30)"
    sleep 2
done

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor (which starts Nginx and PHP-FPM)
echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
