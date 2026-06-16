#!/usr/bin/env bash
# One-shot console deploy + hardening, pulled from GitHub on the VPS itself.
# Run as root from a cloned repo: bash <repo>/deploy/setup.sh
# Safe to re-run. No secrets embedded.
export DEBIAN_FRONTEND=noninteractive NEEDRESTART_MODE=a
HERE="$(cd "$(dirname "$0")/.." && pwd)"          # repo root
CV=/var/www/mluthfirr_website
CS=/var/www/logilink_cs
say() { echo ">>> $*"; }

echo "================ 1) CV + PORTFOLIO PREVIEW ================"
if [ -d "$CV" ]; then
    cp "$HERE/resources/views/cv.blade.php" "$CV/resources/views/cv.blade.php"
    cp "$HERE/public/css/cv.css"            "$CV/public/css/cv.css"
    cp "$HERE/public/js/cv.js"              "$CV/public/js/cv.js"
    cp "$HERE/config/profile.php"           "$CV/config/profile.php"
    mkdir -p "$CV/public/img"
    cp "$HERE/public/img/"*.png             "$CV/public/img/" 2>/dev/null
    # explicit secure cookie
    if grep -q '^SESSION_SECURE_COOKIE=' "$CV/.env"; then
        sed -i 's|^SESSION_SECURE_COOKIE=.*|SESSION_SECURE_COOKIE=true|' "$CV/.env"
    else echo 'SESSION_SECURE_COOKIE=true' >> "$CV/.env"; fi
    chown -R www-data:www-data "$CV/public/img" "$CV/resources/views/cv.blade.php" "$CV/public/css/cv.css" "$CV/public/js/cv.js" "$CV/config/profile.php" "$CV/.env"
    ( cd "$CV" && php artisan view:clear >/dev/null && php artisan config:clear >/dev/null && php artisan config:cache >/dev/null && php artisan route:cache >/dev/null && php artisan view:cache >/dev/null )
    say "CV updated (preview portfolio + secure cookie)"
else say "CV dir not found, skipped"; fi

echo "================ 2) CS LOGIN INFO-LEAK FIX ================"
LOGIN="$CS/resources/views/auth/login.blade.php"
if [ -f "$LOGIN" ]; then
    sed -i 's#Akun demo:.*#Akses khusus tim Customer Service Logilink.#' "$LOGIN"
    sed -i 's#placeholder="admin@logilink.test"#placeholder="you@company.com" autocomplete="username"#' "$LOGIN"
    chown www-data:www-data "$LOGIN"
    ( cd "$CS" && php artisan view:clear >/dev/null && php artisan view:cache >/dev/null )
    say "CS login demo-credentials removed"
else say "CS login not found, skipped"; fi

echo "================ 3) NGINX SECURITY HEADERS ================"
cat > /etc/nginx/conf.d/00-security.conf <<'NGINX'
server_tokens off;
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-Frame-Options "SAMEORIGIN" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
add_header Permissions-Policy "geolocation=(), microphone=(), camera=(), payment=()" always;
add_header Cross-Origin-Opener-Policy "same-origin-allow-popups" always;
add_header Content-Security-Policy-Report-Only "default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://static.cloudflareinsights.com https://challenges.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data:; connect-src 'self' https://cloudflareinsights.com; frame-src https://challenges.cloudflare.com; frame-ancestors 'self'; base-uri 'self'; form-action 'self'; object-src 'none'" always;
NGINX
if nginx -t 2>/dev/null; then systemctl reload nginx; say "security headers active"; else rm -f /etc/nginx/conf.d/00-security.conf; say "nginx test failed, headers reverted"; fi

echo "================ 4) SSH HARDENING (non-lockout) ================"
cat > /etc/ssh/sshd_config.d/99-hardening.conf <<'SSHC'
MaxAuthTries 3
LoginGraceTime 30
PermitEmptyPasswords no
X11Forwarding no
ClientAliveInterval 300
ClientAliveCountMax 2
SSHC
if sshd -t 2>/dev/null; then systemctl reload ssh 2>/dev/null || systemctl reload sshd 2>/dev/null; say "sshd hardened"; else rm -f /etc/ssh/sshd_config.d/99-hardening.conf; say "sshd test failed, reverted"; fi

echo "================ 5) fail2ban + auto-updates ================"
for i in 1 2 3; do apt-get install -y fail2ban unattended-upgrades >/tmp/apt-setup.log 2>&1 && break; sleep 5; done
cat > /etc/fail2ban/jail.d/sshd.local <<F2B
[sshd]
enabled = true
backend = systemd
maxretry = 4
findtime = 10m
bantime = 1h
ignoreip = 127.0.0.1/8 ::1
F2B
systemctl enable fail2ban >/dev/null 2>&1; systemctl restart fail2ban
printf 'APT::Periodic::Update-Package-Lists "1";\nAPT::Periodic::Unattended-Upgrade "1";\n' > /etc/apt/apt.conf.d/20auto-upgrades
systemctl enable --now unattended-upgrades >/dev/null 2>&1
say "fail2ban=$(systemctl is-active fail2ban)  unattended=$(systemctl is-enabled unattended-upgrades 2>/dev/null)"

echo "================ 6) Rotate WhatsApp gateway token ================"
if [ -f "$CS/.env" ] && grep -q 'change-me' "$CS/.env"; then
    NEWTOK=$(openssl rand -hex 24)
    sed -i "s|^WA_GATEWAY_TOKEN=.*|WA_GATEWAY_TOKEN=${NEWTOK}|" "$CS/.env" "$CS/whatsapp-gateway/.env"
    chown www-data:www-data "$CS/.env" "$CS/whatsapp-gateway/.env"
    ( cd "$CS" && php artisan config:clear >/dev/null && php artisan config:cache >/dev/null )
    systemctl restart logilink-wa-gateway 2>/dev/null
    say "WA token rotated; gateway=$(systemctl is-active logilink-wa-gateway 2>/dev/null)"
else say "WA token already custom or CS missing, skipped"; fi

echo "================ DONE ================"
echo "CV:  https://mluthfirr.id   CS: https://cs.mluthfirr.id"
