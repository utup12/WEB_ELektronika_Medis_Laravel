#!/bin/sh

set -eu

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/app/database/database.sqlite}"
    mkdir -p "$(dirname "$DB_FILE")"
    touch "$DB_FILE"
    chown www-data:www-data "$DB_FILE"

    php artisan migrate --force --no-interaction --no-ansi
    php artisan db:seed --class=Database\\Seeders\\ProductionUserSeeder --force --no-interaction --no-ansi
fi

exec "$@"
