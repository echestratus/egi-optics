#!/usr/bin/env bash
# Backup the egi-optics.com database and the deployed theme/plugin before a deploy.
#
# Usage (on the server):  bash backup.sh [label]
#   SITE_PATH  WordPress root (default: ~/domains/egi-optics.com/public_html)
#   BACKUP_DIR where backups are stored (default: ~/backups/egi-optics)
#   KEEP       number of deploy backups to keep (default: 10; the pre-overhaul-* snapshot is never pruned)
set -euo pipefail

SITE_PATH="${SITE_PATH:-$HOME/domains/egi-optics.com/public_html}"
BACKUP_DIR="${BACKUP_DIR:-$HOME/backups/egi-optics}"
KEEP="${KEEP:-10}"
LABEL="${1:-deploy}"
TS="$(date -u +%Y%m%d-%H%M%S)"
DEST="$BACKUP_DIR/$LABEL-$TS"

cd "$SITE_PATH"
mkdir -p "$DEST"
chmod 700 "$BACKUP_DIR" "$DEST"

echo "[backup] $DEST"

# --- Database (direct mysqldump: WP-CLI cannot always spawn it under CageFS).
DB_NAME="$(wp config get DB_NAME --skip-plugins --skip-themes)"
DB_USER="$(wp config get DB_USER --skip-plugins --skip-themes)"
DB_PASS="$(wp config get DB_PASSWORD --skip-plugins --skip-themes)"
DB_HOST="$(wp config get DB_HOST --skip-plugins --skip-themes)"
MYSQL_PWD="$DB_PASS" mysqldump --host="$DB_HOST" --user="$DB_USER" \
	--single-transaction --quick --add-drop-table --default-character-set=utf8mb4 \
	"$DB_NAME" | gzip > "$DEST/db.sql.gz"
gzip -t "$DEST/db.sql.gz"
echo "[backup] database: $(du -h "$DEST/db.sql.gz" | cut -f1)"

# --- Code currently in production (theme + plugin) so a deploy can be reverted quickly.
INCLUDE=()
[ -d wp-content/themes/egi-optics ] && INCLUDE+=(wp-content/themes/egi-optics)
[ -d wp-content/plugins/egi-optics-core ] && INCLUDE+=(wp-content/plugins/egi-optics-core)
if [ ${#INCLUDE[@]} -gt 0 ]; then
	tar -czf "$DEST/code.tar.gz" "${INCLUDE[@]}"
	echo "[backup] code: $(du -h "$DEST/code.tar.gz" | cut -f1)"
else
	echo "[backup] no theme/plugin deployed yet - code archive skipped"
fi

cp -a wp-config.php "$DEST/wp-config.php.bak"
cp -a .htaccess "$DEST/htaccess.bak" 2>/dev/null || true
chmod 600 "$DEST"/*

# --- Record versions for the runbook.
{
	echo "timestamp_utc=$TS"
	echo "label=$LABEL"
	echo "wp_core=$(wp core version --skip-plugins --skip-themes)"
	echo "theme=$(wp theme get egi-optics --field=version --skip-plugins --skip-themes 2>/dev/null || echo none)"
	echo "plugin=$(wp plugin get egi-optics-core --field=version --skip-plugins --skip-themes 2>/dev/null || echo none)"
	echo "git_sha=${GITHUB_SHA:-manual}"
} > "$DEST/MANIFEST"

# --- Prune old deploy backups (never touch pre-overhaul-* snapshots).
mapfile -t OLD < <(ls -1d "$BACKUP_DIR"/"$LABEL"-* 2>/dev/null | sort | head -n -"$KEEP")
for d in "${OLD[@]:-}"; do
	[ -n "$d" ] && rm -rf "$d" && echo "[backup] pruned $d"
done

echo "[backup] done"
