#!/bin/bash
set -e

cd /app

# DO NOT create .env file - Railway sets env vars at container level
# Laravel reads from environment variables directly

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY not set, generating..."
    php artisan key:generate --force
fi

# Create storage link
php artisan storage:link --force 2>/dev/null || true

# Clear any old cache
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Cache for production (after env vars are available)
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting server on port ${PORT:-8080}..."

# Start the application
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
