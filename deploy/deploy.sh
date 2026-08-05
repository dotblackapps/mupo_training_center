#!/usr/bin/env bash
set -Eeuo pipefail

APP_DIR="${APP_DIR:-/var/www/html/mupo_training_center}"
REMOTE="${REMOTE:-origin}"
BRANCH="${BRANCH:-main}"
PHP_BIN="${PHP_BIN:-php8.2}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
NPM_BIN="${NPM_BIN:-npm}"
RUN_COMPOSER="${RUN_COMPOSER:-1}"
RUN_NPM_INSTALL="${RUN_NPM_INSTALL:-0}"
RUN_NPM_BUILD="${RUN_NPM_BUILD:-0}"
RUN_MIGRATIONS="${RUN_MIGRATIONS:-1}"
RELOAD_APACHE="${RELOAD_APACHE:-1}"
APACHE_SERVICE="${APACHE_SERVICE:-apache2}"
WEB_USER="${WEB_USER:-www-data}"
WEB_GROUP="${WEB_GROUP:-www-data}"
DEPLOY_USER="${DEPLOY_USER:-${SUDO_USER:-$USER}}"

log() {
  printf '\n[%s] %s\n' "$(date '+%Y-%m-%d %H:%M:%S')" "$*"
}

fail() {
  printf 'Deploy failed: %s\n' "$*" >&2
  exit 1
}

run_as_web() {
  sudo -u "$WEB_USER" HOME=/tmp "$@"
}

ensure_clean_deploy_target() {
  [[ -d "$APP_DIR/.git" ]] || fail "$APP_DIR is not a Git checkout"
  [[ -f "$APP_DIR/artisan" ]] || fail "$APP_DIR does not look like a Laravel app"
  [[ -f "$APP_DIR/.env" ]] || fail "$APP_DIR/.env is missing"
}

fix_permissions() {
  sudo chown -R "$DEPLOY_USER:$WEB_GROUP" storage bootstrap/cache
  sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
  sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
}

restore_compat_assets() {
  if [[ -f public/mupo/assets/images/mupo-logo_1.jpeg ]]; then
    sudo mkdir -p public/uploads/settings public/public/uploads/settings
    sudo cp public/mupo/assets/images/mupo-logo_1.jpeg public/uploads/settings/mupo-logo_1.jpeg
    sudo cp public/mupo/assets/images/mupo-logo_1.jpeg public/uploads/settings/logo.png
    sudo cp public/uploads/settings/mupo-logo_1.jpeg public/public/uploads/settings/mupo-logo_1.jpeg
    sudo cp public/uploads/settings/logo.png public/public/uploads/settings/logo.png
  fi

  if [[ -f public/frontend/infixlmstheme/img/favicon.png ]]; then
    sudo mkdir -p public/uploads/settings public/public/uploads/settings
    sudo cp public/frontend/infixlmstheme/img/favicon.png public/uploads/settings/favicon.png
    sudo cp public/frontend/infixlmstheme/img/favicon.png public/uploads/settings/mupo_favicon.png
    sudo cp public/uploads/settings/favicon.png public/public/uploads/settings/favicon.png
    sudo cp public/uploads/settings/mupo_favicon.png public/public/uploads/settings/mupo_favicon.png
  fi

  sudo chown -R "$WEB_USER:$WEB_GROUP" public/uploads/settings public/public/uploads/settings 2>/dev/null || true
  sudo find public/uploads/settings public/public/uploads/settings -type f -exec chmod 644 {} \; 2>/dev/null || true
}

ensure_storage_link() {
  if [[ ! -L public/storage ]]; then
    run_as_web "$PHP_BIN" artisan storage:link || true
  fi
}

cd "$APP_DIR"
ensure_clean_deploy_target

log "Putting app into maintenance mode"
run_as_web "$PHP_BIN" artisan down || true

cleanup() {
  local status=$?
  if [[ $status -ne 0 ]]; then
    printf '\nDeploy exited with status %s. Bringing app back up.\n' "$status" >&2
  fi
  run_as_web "$PHP_BIN" artisan up >/dev/null 2>&1 || true
}
trap cleanup EXIT

log "Fetching $REMOTE/$BRANCH"
git fetch "$REMOTE" "$BRANCH"

log "Deploying $REMOTE/$BRANCH"
git checkout "$BRANCH"
git reset --hard "$REMOTE/$BRANCH"
git clean -fd --exclude=.env --exclude=storage --exclude=public/uploads --exclude=public/public/uploads --exclude=public/storage

if [[ "$RUN_COMPOSER" == "1" ]]; then
  log "Installing PHP dependencies"
  fix_permissions
  "$COMPOSER_BIN" install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts
  run_as_web "$PHP_BIN" artisan package:discover --ansi
fi

if [[ "$RUN_NPM_INSTALL" == "1" ]]; then
  log "Installing frontend dependencies"
  "$NPM_BIN" ci
fi

if [[ "$RUN_NPM_BUILD" == "1" ]]; then
  log "Building frontend assets"
  NODE_OPTIONS="${NODE_OPTIONS:-} --openssl-legacy-provider" "$NPM_BIN" run production
fi

log "Preparing Laravel runtime files"
fix_permissions
restore_compat_assets
ensure_storage_link
run_as_web "$PHP_BIN" artisan optimize:clear

if [[ "$RUN_MIGRATIONS" == "1" ]]; then
  log "Running migrations"
  run_as_web "$PHP_BIN" artisan migrate --force
fi

log "Rebuilding safe Laravel caches"
run_as_web "$PHP_BIN" artisan config:cache
run_as_web "$PHP_BIN" artisan view:clear

fix_permissions

if [[ "$RELOAD_APACHE" == "1" ]]; then
  log "Reloading Apache"
  sudo systemctl reload "$APACHE_SERVICE"
fi

log "Deployment complete"
df -h /
