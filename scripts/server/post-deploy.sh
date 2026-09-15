#!/usr/bin/env bash
# Post-deploy steps on the server: activate theme/plugin idempotently, flush rewrites and caches.
#
# Usage:  bash post-deploy.sh
#   SITE_PATH       WordPress root (default: ~/domains/egi-optics.com/public_html)
#   ACTIVATE_THEME  "1" to activate egi-optics if it is not active yet (default: 1 once cutover is done)
set -euo pipefail

SITE_PATH="${SITE_PATH:-$HOME/domains/egi-optics.com/public_html}"
ACTIVATE_THEME="${ACTIVATE_THEME:-1}"
cd "$SITE_PATH"

WP="wp --skip-themes"   # the legacy theme prints notices under WP-CLI; our theme is safe either way.

echo "[post-deploy] plugin"
if $WP plugin is-installed egi-optics-core; then
	$WP plugin is-active egi-optics-core || $WP plugin activate egi-optics-core
fi

echo "[post-deploy] theme"
if [ "$ACTIVATE_THEME" = "1" ] && wp theme is-installed egi-optics; then
	CURRENT="$(wp option get stylesheet --skip-plugins --skip-themes)"
	if [ "$CURRENT" != "egi-optics" ]; then
		wp theme activate egi-optics
		echo "[post-deploy] theme activated (was: $CURRENT)"
	fi
fi

echo "[post-deploy] rewrite + caches"
wp rewrite flush --hard 2>/dev/null || wp rewrite flush
wp cache flush
wp transient delete --all >/dev/null 2>&1 || true
if wp plugin is-active litespeed-cache; then
	wp litespeed-purge all || true
fi

echo "[post-deploy] versions"
echo "  core:   $(wp core version)"
echo "  theme:  $(wp theme get egi-optics --field=version 2>/dev/null || echo n/a) ($(wp option get stylesheet))"
echo "  plugin: $(wp plugin get egi-optics-core --field=version 2>/dev/null || echo n/a)"
echo "[post-deploy] done"
