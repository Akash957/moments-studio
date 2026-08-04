#!/bin/bash
set -e

cd /app

echo "=== Starting Laravel Railway Entrypoint ==="

# Railway passes $PORT environment variable. Fallback to 8080 if not set.
LISTEN_PORT="${PORT:-8080}"

# Auto-detect & clean Railway MySQL variables
DB_HOST="${DB_HOST:-$MYSQLHOST}"
if [ -z "$DB_HOST" ] || [ "$DB_HOST" = "127.0.0.1" ] || [ "$DB_HOST" = "localhost" ]; then
    DB_HOST="${MYSQLHOST:-mysql.railway.internal}"
fi

DB_PORT="${DB_PORT:-$MYSQLPORT}"
[ -z "$DB_PORT" ] && DB_PORT="${MYSQLPORT:-3306}"

DB_DATABASE="${DB_DATABASE:-$MYSQLDATABASE}"
[ -z "$DB_DATABASE" ] && DB_DATABASE="${MYSQLDATABASE:-railway}"

DB_USERNAME="${DB_USERNAME:-$MYSQLUSER}"
[ -z "$DB_USERNAME" ] && DB_USERNAME="${MYSQLUSER:-root}"

DB_PASSWORD="${DB_PASSWORD:-$MYSQLPASSWORD}"

echo "Database Configuration:"
echo "Host: $DB_HOST | Port: $DB_PORT | DB: $DB_DATABASE | User: $DB_USERNAME"

# Construct runtime .env file for Laravel
cat <<EOF > /app/.env
APP_NAME="${APP_NAME:-Moments Studio}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-base64:/P1cA42ruPgrHuYjvK9/Kt50SKGIM95nKsu55D+W6cg=}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-https://love-studios.up.railway.app}

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error
EOF

# Create storage symlink
php artisan storage:link --force || true

# Clear previous caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Attempt database migration with retry loop
echo "Running migrations..."
MIGRATED=0
for i in {1..3}; do
    if php artisan migrate --force; then
        MIGRATED=1
        echo "Database migrations completed successfully!"
        break
    fi
    echo "Migration attempt $i failed. Retrying in 2 seconds..."
    sleep 2
done

if [ $MIGRATED -eq 0 ]; then
    echo "WARNING: Could not complete migration automatically. Website will still start up..."
fi

# Cache config & routes for production speed
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting PHP Web Server on 0.0.0.0:${LISTEN_PORT}..."
exec php -S 0.0.0.0:${LISTEN_PORT} -t public public/index.php
