#!/bin/bash
set -e

cd /app

echo "=== Starting Laravel Railway Production Entrypoint ==="

LISTEN_PORT="${PORT:-8080}"

# Auto-detect MySQL credentials from Railway env vars
DB_HOST="${DB_HOST:-$MYSQLHOST}"
if [ -z "$DB_HOST" ] || [ "$DB_HOST" = "127.0.0.1" ] || [ "$DB_HOST" = "localhost" ]; then
    DB_HOST="${MYSQLHOST:-mysql.railway.internal}"
fi

DB_PORT="${DB_PORT:-$MYSQLPORT}"
[ -z "$DB_PORT" ] && DB_PORT="3306"

DB_DATABASE="${DB_DATABASE:-$MYSQLDATABASE}"
[ -z "$DB_DATABASE" ] && DB_DATABASE="railway"

DB_USERNAME="${DB_USERNAME:-$MYSQLUSER}"
[ -z "$DB_USERNAME" ] && DB_USERNAME="root"

DB_PASSWORD="${DB_PASSWORD:-$MYSQLPASSWORD}"

# Strip accidental quotes from environment variables if present
DB_HOST=$(echo "$DB_HOST" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_PORT=$(echo "$DB_PORT" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_DATABASE=$(echo "$DB_DATABASE" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_USERNAME=$(echo "$DB_USERNAME" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_PASSWORD=$(echo "$DB_PASSWORD" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")

# Clean raw un-evaluated Railway reference strings if present
if [[ "$DB_PASSWORD" == "\${{"* ]]; then
    DB_PASSWORD=""
fi
if [[ "$DB_HOST" == "\${{"* ]]; then
    DB_HOST="mysql.railway.internal"
fi

echo "Database Configuration:"
echo "Host: $DB_HOST | Port: $DB_PORT | DB: $DB_DATABASE | User: $DB_USERNAME"

# Construct primary MySQL runtime .env file
cat <<EOF > /app/.env
APP_NAME="${APP_NAME:-Moments Studio}"
APP_ENV=production
APP_KEY=${APP_KEY:-base64:/P1cA42ruPgrHuYjvK9/Kt50SKGIM95nKsu55D+W6cg=}
APP_DEBUG=false
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

php artisan storage:link --force || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Test database connection & run migrations
USE_SQLITE=0
echo "Attempting MySQL migrations..."
if ! php artisan migrate --force; then
    echo "WARNING: MySQL connection failed. Switching to SQLite fallback for 100% production uptime..."
    USE_SQLITE=1
fi

if [ $USE_SQLITE -eq 1 ]; then
    echo "Configuring SQLite production database..."
    mkdir -p /app/database
    touch /app/database/database.sqlite
    
    cat <<EOF > /app/.env
APP_NAME="${APP_NAME:-Moments Studio}"
APP_ENV=production
APP_KEY=${APP_KEY:-base64:/P1cA42ruPgrHuYjvK9/Kt50SKGIM95nKsu55D+W6cg=}
APP_DEBUG=false
APP_URL=${APP_URL:-https://love-studios.up.railway.app}

DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_CHANNEL=stack
LOG_LEVEL=error
EOF
    php artisan config:clear || true
    php artisan migrate --force || true
fi

# Production Cache
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Production Server on 0.0.0.0:${LISTEN_PORT}..."
exec php -S 0.0.0.0:${LISTEN_PORT} -t public public/index.php
