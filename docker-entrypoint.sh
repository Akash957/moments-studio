#!/bin/bash
set -e

cd /app

# Copy .env.example if .env doesn't exist (Railway sets env vars directly)
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not set via env
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Create storage link
php artisan storage:link --force 2>/dev/null || true

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Start the application
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
