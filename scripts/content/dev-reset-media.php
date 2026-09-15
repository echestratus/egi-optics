<?php
/**
 * Development helper: delete previously imported assets so 02-media.php re-imports them
 * (e.g. after regenerating video posters). Never run in production without a backup.
 *
 * Run: EGI_RESET_PATTERN='-poster.jpg' wp eval-file scripts/content/dev-reset-media.php
 *      (pattern is a substring of the source file name; default "-poster.jpg")
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

$egi_pattern = getenv( 'EGI_RESET_PATTERN' ) ? getenv( 'EGI_RESET_PATTERN' ) : '-poster.jpg';
$egi_deleted = 0;

foreach ( get_posts(
	array(
		'post_type'   => 'attachment',
		'post_status' => 'inherit',
		'numberposts' => -1,
		'fields'      => 'ids',
	)
) as $egi_id ) {
	$egi_source = (string) get_post_meta( $egi_id, '_egi_source', true );
	if ( '' !== $egi_source && false !== strpos( $egi_source, $egi_pattern ) ) {
		wp_delete_attachment( $egi_id, true );
		egi_content_log( "  • deleted attachment #{$egi_id} ({$egi_source})" );
		++$egi_deleted;
	}
}

egi_content_log( "Deleted {$egi_deleted} attachment(s) matching '{$egi_pattern}'. Re-run 02-media.php to import again." );
