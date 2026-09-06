#!/bin/sh
set -e
cd /var/www/html

if [ -z "$APP_KEY" ]; then
  echo "FATAL: APP_KEY is empty. Generate one with 'php artisan key:generate --show' and set APP_KEY." >&2
  exit 1
fi

# make sure writable dirs are writable (matters when storage is a mounted volume)
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

# wait for the database to accept connections
: "${DB_PORT:=3306}"
if [ -n "$DB_HOST" ]; then
  echo "Waiting for database $DB_HOST:$DB_PORT ..."
  i=0
  until php -r "exit(@fsockopen(getenv('DB_HOST'), (int) getenv('DB_PORT')) ? 0 : 1);"; do
    i=$((i + 1))
    [ "$i" -ge 30 ] && echo "Database not reachable, giving up." >&2 && exit 1
    sleep 2
  done
fi

php artisan storage:link 2>/dev/null || true
php artisan migrate --force
php artisan package:discover --ansi
php artisan config:cache
php artisan view:cache
php artisan filament:optimize 2>/dev/null || true
# NOTE: route:cache intentionally skipped — closure-based routes are not serializable.

exec "$@"
