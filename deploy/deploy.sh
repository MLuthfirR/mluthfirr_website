#!/usr/bin/env bash
# Lightweight routine deploy — run by GitHub Actions after `git pull` in the webroot.
# (One-time server hardening lives in setup.sh, not here.)
set -e
cd /var/www/mluthfirr_website

# Update PHP deps if composer is available (vendor persists across git resets,
# so this is a no-op when deps are unchanged and harmless when composer is absent).
command -v composer >/dev/null && composer install --no-dev --optimize-autoloader --no-interaction --no-progress 2>/dev/null || true

php artisan migrate --force 2>/dev/null || true
php artisan config:clear  >/dev/null
php artisan config:cache  >/dev/null
php artisan route:cache   >/dev/null
php artisan view:clear    >/dev/null
php artisan view:cache    >/dev/null

chown -R www-data:www-data .
echo "deployed $(git rev-parse --short HEAD) at $(date -u +%FT%TZ)"
