<?php
/**
 * Local seed: runs the content migration against the wp-env site so developers can review the theme
 * with real content. Requires ./assets/import to be prepared (scripts/dev/prepare-assets.ps1) and
 * mapped into the container as /var/www/html/egi-assets (see .wp-env.json).
 *
 * Run: npm run env:seed
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

if ( 'production' === wp_get_environment_type() ) {
	WP_CLI::error( 'seed-local.php must not run in production. Use run-production.php.' );
}

foreach ( array( '01-settings.php', '02-media.php', '03-products.php', '04-pages.php', '05-navigation.php', '06-news.php' ) as $egi_script ) {
	require __DIR__ . '/' . $egi_script;
}

// Remove the WordPress sample content on a fresh local install.
foreach ( array(
	'hello-world' => 'post',
	'sample-page' => 'page',
) as $egi_slug => $egi_type ) {
	$egi_post = get_page_by_path( $egi_slug, OBJECT, $egi_type );
	if ( $egi_post ) {
		wp_trash_post( $egi_post->ID );
	}
}

WP_CLI::success( 'Local content seeded. Open ' . home_url( '/' ) );
