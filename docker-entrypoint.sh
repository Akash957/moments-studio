#!/bin/bash
set -e

cd /app

echo "=== Starting Laravel Railway Entrypoint ==="

# Force Port to 8080 to match Railway Networking Target Port
export PORT=8080

# Auto-detect Railway MySQL default environment variables if present
if [ -n "$MYSQLHOST" ]; then
    export DB_HOST="${DB_HOST:-$MYSQLHOST}"
fi
if [ -n "$MYSQLPORT" ]; then
    export DB_PORT="${DB_PORT:-$MYSQLPORT}"
fi
if [ -n "$MYSQLDATABASE" ]; then
    export DB_DATABASE="${DB_DATABASE:-$MYSQLDATABASE}"
fi
if [ -n "$MYSQLUSER" ]; then
    export DB_USERNAME="${DB_USERNAME:-$MYSQLUSER}"
fi
if [ -n "$MYSQLPASSWORD" ]; then
    export DB_PASSWORD="${DB_PASSWORD:-$MYSQLPASSWORD}"
fi
if [ -n "$MYSQL_URL" ]; then
    export DB_URL="${DB_URL:-$MYSQL_URL}"
fi

# Fallback defaults if still empty
export DB_CONNECTION="${DB_CONNECTION:-mysql}"
export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-false}"
export SESSION_DRIVER="${SESSION_DRIVER:-file}"
export CACHE_STORE="${CACHE_STORE:-file}"
export QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"

# Construct runtime .env file for Laravel
cat <<EOF > /app/.env
APP_NAME="${APP_NAME:-Moments Studio}"
APP_ENV=${APP_ENV}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG}
APP_URL=${APP_URL:-https://love-studios.up.railway.app}

DB_CONNECTION=${DB_CONNECTION}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
${DB_URL:+DB_URL=${DB_URL}}

SESSION_DRIVER=${SESSION_DRIVER}
CACHE_STORE=${CACHE_STORE}
QUEUE_CONNECTION=${QUEUE_CONNECTION}
LOG_CHANNEL=stack
LOG_LEVEL=error
EOF

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Create storage symlink
php artisan storage:link --force || true

# Clear previous caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run database migrations
echo "Running migrations..."
if ! php artisan migrate --force; then
    echo "WARNING: Migration failed or database not ready yet. Continuing server startup..."
fi

# Cache config & routes for production speed
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting PHP Web Server on port 8080..."
exec php -S 0.0.0.0:8080 -t public public/index.php
