#!/usr/bin/env sh

set -eu

# A build can contain cached local configuration. Clear it before Laravel reads
# Railway's runtime variables, otherwise migrations may use the SQLite fallback.
php artisan config:clear

if [ "${DB_CONNECTION:-}" != "mysql" ]; then
    echo "ERROR: DB_CONNECTION must be set to mysql in the Railway app service." >&2
    exit 1
fi

# Railway may provide either a single DB_URL or individual MySQL variables.
if [ -z "${DB_URL:-}" ]; then
    for variable_name in DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD; do
        eval "variable_value=\${${variable_name}:-}"

        if [ -z "$variable_value" ]; then
            echo "ERROR: ${variable_name} is missing from the Railway app service variables." >&2
            exit 1
        fi
    done
fi

# Prepare the database and Laravel caches before the new deployment goes live.
php artisan migrate --force --no-interaction
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
