#!/usr/bin/env bash
# Lightweight routine deploy — run by GitHub Actions after `git pull` in the webroot.
# (One-time server hardening lives in setup.sh, not here.)
set -e
cd /var/www/mluthfirr_website

# Install PHP deps only when the lock file changed (fast no-op otherwise).
composer install --no-dev --optimize-autoloader --no-interaction --no-progress 2>/dev/null || true

php artisan migrate --force 2>/dev/null || true
php artisan config:clear  >/dev/null
php artisan config:cache  >/dev/null
php artisan route:cache   >/dev/null
php artisan view:clear    >/dev/null
php artisan view:cache    >/dev/null

chown -R www-data:www-data .
echo "deployed $(git rev-parse --short HEAD) at $(date -u +%FT%TZ)"
