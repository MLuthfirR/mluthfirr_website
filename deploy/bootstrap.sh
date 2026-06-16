#!/usr/bin/env bash
# One-time bootstrap for GitHub Actions auto-deploy:
#   1) register the deploy public key in /root/.ssh/authorized_keys
#   2) turn the live webroot into a git checkout tracking origin/main
# Safe: preserves .env; the live site is only swapped in if every step succeeds.
set -e
REPO="https://github.com/MLuthfirR/mluthfirr_website.git"
WEB=/var/www/mluthfirr_website
PUB='ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIGpD74Pvc7a3JMArRaAfY+QeJmdwU8b9osWtX5Dk6szZ github-actions-deploy'

echo ">>> [1/4] register deploy key"
mkdir -p /root/.ssh && chmod 700 /root/.ssh
touch /root/.ssh/authorized_keys && chmod 600 /root/.ssh/authorized_keys
grep -qF "$PUB" /root/.ssh/authorized_keys || echo "$PUB" >> /root/.ssh/authorized_keys

echo ">>> [2/4] fresh clone (preserving .env)"
cd /var/www
cp "$WEB/.env" /tmp/mlw.env.bak
rm -rf mluthfirr_website_new
git clone -q --depth 1 "$REPO" mluthfirr_website_new
cp /tmp/mlw.env.bak mluthfirr_website_new/.env
cd mluthfirr_website_new

echo ">>> [3/4] composer install + caches (takes ~1 min)"
composer install --no-dev --optimize-autoloader --no-interaction --no-progress
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache database
touch database/database.sqlite 2>/dev/null || true
php artisan config:cache >/dev/null && php artisan route:cache >/dev/null && php artisan view:cache >/dev/null
chown -R www-data:www-data /var/www/mluthfirr_website_new

echo ">>> [4/4] atomic swap"
cd /var/www
mv mluthfirr_website "mluthfirr_website_old_$(date +%s)"
mv mluthfirr_website_new mluthfirr_website
systemctl reload nginx
echo "BOOTSTRAP_DONE — webroot is now a git checkout; GitHub Actions can deploy."
