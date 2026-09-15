<?php
/**
 * Production content migration: runs the numbered scripts in order, including cleanup.
 * Take a backup first (scripts/server/backup.sh). Idempotent; safe to re-run.
 *
 * Run on the server:
 *   cd ~/domains/egi-optics.com/public_html
 *   EGI_ASSETS_DIR=$HOME/egi-content-assets wp eval-file $HOME/egi-scripts/content/run-production.php
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

if ( ! egi_content_assets_dir() ) {
	WP_CLI::error( 'Assets directory not found. Set EGI_ASSETS_DIR to the prepared media folder.' );
}

foreach ( array( '01-settings.php', '02-media.php', '03-products.php', '04-pages.php', '05-navigation.php', '06-news.php', '07-cleanup.php' ) as $egi_script ) {
	require __DIR__ . '/' . $egi_script;
}

flush_rewrite_rules( false );
WP_CLI::success( 'Production content migrated. Now activate the theme (see docs/DEPLOYMENT_RUNBOOK.md).' );
