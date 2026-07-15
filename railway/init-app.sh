#!/usr/bin/env bash

set -euo pipefail

# Prepare the database and Laravel caches before the new deployment goes live.
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
