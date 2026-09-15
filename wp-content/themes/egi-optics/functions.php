<?php
/**
 * EGI Optics block theme bootstrap.
 *
 * @package EGI_Optics
 */

defined( 'ABSPATH' ) || exit;

define( 'EGI_OPTICS_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'EGI_OPTICS_DIR', get_template_directory() );
define( 'EGI_OPTICS_URI', get_template_directory_uri() );

require_once EGI_OPTICS_DIR . '/inc/setup.php';
require_once EGI_OPTICS_DIR . '/inc/enqueue.php';
require_once EGI_OPTICS_DIR . '/inc/block-styles.php';
require_once EGI_OPTICS_DIR . '/inc/patterns.php';
require_once EGI_OPTICS_DIR . '/inc/template-helpers.php';
