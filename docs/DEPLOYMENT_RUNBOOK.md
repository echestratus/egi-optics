# Deployment Runbook - egi-optics.com (Hostinger)

Operational commands for deploying, rolling back and restoring. All server commands run as the
hosting user over SSH:

```bash
ssh -p 65002 u406190896@147.93.99.109
cd ~/domains/egi-optics.com/public_html
```

`wp` (WP-CLI 2.12), `rsync`, `mysqldump`, `tar` and `gzip` are available on the server.

## 1. Normal deploy (automatic)

Merge a PR into `main`. GitHub Actions `deploy.yml` does, in order:

1. `scripts/server/backup.sh` (database + current theme/plugin -> `~/backups/egi-optics/<ts>/`)
2. `rsync` theme and plugin
3. `scripts/server/post-deploy.sh` (activate, flush rewrites, flush caches, purge LiteSpeed)
4. health check on `/`, `/products/`, `/news/`

Watch the run: `gh run watch` or the *Actions* tab. A red run means production may be inconsistent:
go to section 3.

## 2. Manual deploy of a specific ref

From the repository page: *Actions -> Deploy to production -> Run workflow*, choose the branch or tag.
Equivalent CLI:

```bash
gh workflow run deploy.yml --ref v1.0.0
```

## 3. Rollback

### 3a. Roll back code (fast, preferred)

Re-deploy the previous tag: `gh workflow run deploy.yml --ref vX.Y.Z` (the previous release).
This re-runs the backup step first, so nothing is lost.

### 3b. Restore the theme/plugin tarball from a backup

```bash
cd ~/domains/egi-optics.com/public_html
ls ~/backups/egi-optics/                # pick the timestamp
B=~/backups/egi-optics/<timestamp>
tar -xzf "$B/code.tar.gz" -C .          # restores wp-content/themes/egi-optics and plugins/egi-optics-core
wp cache flush && wp litespeed-purge all
```

### 3c. Restore the database (last resort - announce first)

```bash
B=~/backups/egi-optics/<timestamp>
wp db export ~/backups/egi-optics/pre-restore-$(date +%Y%m%d-%H%M%S).sql   # safety copy
gunzip -c "$B/db.sql.gz" | wp db import -
wp cache flush && wp litespeed-purge all
```

If `wp db export` fails on this host (WP-CLI cannot spawn `mysqldump` under CageFS in some sessions),
use the direct form used by `backup.sh`:

```bash
MYSQL_PWD="$(wp config get DB_PASSWORD)" mysqldump -h "$(wp config get DB_HOST)" -u "$(wp config get DB_USER)" \
  --single-transaction --quick --add-drop-table --default-character-set=utf8mb4 "$(wp config get DB_NAME)" | gzip > db.sql.gz
```

### The pre-overhaul snapshot

`~/backups/egi-optics/pre-overhaul-20260915-022900/` contains the complete site as it was before the
2026-09 redesign (database, full `wp-content` incl. uploads, `wp-config.php`, `.htaccess`). Keep it.

## 4. Restore test (monthly)

```bash
scp -P 65002 u406190896@147.93.99.109:~/backups/egi-optics/<ts>/db.sql.gz /tmp/
npm run env:start
gunzip -c /tmp/db.sql.gz | npx wp-env run cli wp db import -
npx wp-env run cli wp search-replace 'https://egi-optics.com' 'http://localhost:8888' --all-tables --precise
npx wp-env run cli wp user update admin --user_pass=password
```

Open http://localhost:8888 and click through Home, a product, News and Contact.

## 5. Rotating the deploy key

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy egi-optics" -f ./deploy_key -N ""
# server: append deploy_key.pub to ~/.ssh/authorized_keys, remove the old public key
gh secret set HOSTINGER_SSH_KEY < deploy_key
shred -u deploy_key deploy_key.pub   # never keep the private key on disk
```

## 6. Useful server commands

```bash
wp theme list; wp plugin list --update=available
wp option get siteurl; wp option get home
wp litespeed-purge all
tail -n 50 ~/domains/egi-optics.com/logs/error_log 2>/dev/null || ls ~/.logs
wp eval-file ~/domains/egi-optics.com/public_html/../../../egi-scripts/... # (content scripts are copied to ~/egi-scripts by the deploy job)
```
