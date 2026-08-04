#!/bin/bash
set -e

cd /app

echo "=== Starting Laravel Railway Production Entrypoint ==="

# Force LISTEN_PORT to 8080 to match Railway Public Networking Target Port 8080
LISTEN_PORT=8080
export PORT=8080

# Clean quotes from env vars if present
DB_HOST=$(echo "${DB_HOST:-$MYSQLHOST}" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_PORT=$(echo "${DB_PORT:-$MYSQLPORT}" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_DATABASE=$(echo "${DB_DATABASE:-$MYSQLDATABASE}" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_USERNAME=$(echo "${DB_USERNAME:-$MYSQLUSER}" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")
DB_PASSWORD=$(echo "${DB_PASSWORD:-$MYSQLPASSWORD}" | sed -e 's/^"//' -e 's/"$//' -e "s/^'//" -e "s/'$//")

# Fix 127.0.0.1 or localhost in Railway container
if [ -z "$DB_HOST" ] || [ "$DB_HOST" = "127.0.0.1" ] || [ "$DB_HOST" = "localhost" ]; then
    DB_HOST="mysql.railway.internal"
fi
[ -z "$DB_PORT" ] && DB_PORT="3306"
[ -z "$DB_DATABASE" ] && DB_DATABASE="railway"
[ -z "$DB_USERNAME" ] && DB_USERNAME="root"

# If DB_PASSWORD contains unresolved Railway reference syntax, clear it
if [[ "$DB_PASSWORD" == "\${{"* ]]; then
    DB_PASSWORD=""
fi

echo "Database Settings:"
echo "Host: $DB_HOST | Port: $DB_PORT | DB: $DB_DATABASE | User: $DB_USERNAME"

# Set runtime env vars in current shell
export DB_CONNECTION=mysql
export DB_HOST="${DB_HOST}"
export DB_PORT="${DB_PORT}"
export DB_DATABASE="${DB_DATABASE}"
export DB_USERNAME="${DB_USERNAME}"
export DB_PASSWORD="${DB_PASSWORD}"

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

USE_SQLITE=0
echo "Attempting MySQL migrations..."
if ! php artisan migrate --force; then
    echo "MySQL connection failed. Switching DB_CONNECTION to sqlite..."
    USE_SQLITE=1
fi

if [ $USE_SQLITE -eq 1 ]; then
    mkdir -p /app/database
    touch /app/database/database.sqlite
    
    # Export SQLite env vars so shell environment overrides parent env vars
    export DB_CONNECTION=sqlite
    export DB_DATABASE=/app/database/database.sqlite
    unset DB_HOST DB_PORT DB_USERNAME DB_PASSWORD

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

echo "Starting Artisan Serve strictly on 0.0.0.0:8080..."
exec php artisan serve --host=0.0.0.0 --port=8080
