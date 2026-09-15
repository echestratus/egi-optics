<?php
/**
 * Plugin Name:       EGI Optics Core
 * Plugin URI:        https://github.com/echestratus/egi-optics
 * Description:       Site-specific functionality for egi-optics.com: Products post type and categories, product meta, legacy URL redirects and security hardening. The theme depends on this plugin for the data model.
 * Version:           1.1.0
 * Requires at least: 6.7
 * Requires PHP:      8.2
 * Author:            PT EGI Optik Indonesia
 * Author URI:        https://egi-optics.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       egi-optics-core
 * Update URI:        false
 *
 * @package EGI_Optics_Core
 */

defined( 'ABSPATH' ) || exit;

define( 'EGI_CORE_VERSION', '1.1.0' );
define( 'EGI_CORE_FILE', __FILE__ );
define( 'EGI_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'EGI_CORE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Post type and taxonomy slugs shared with the theme.
 */
define( 'EGI_CORE_PRODUCT_CPT', 'egi_product' );
define( 'EGI_CORE_PRODUCT_TAX', 'product_category' );

require_once EGI_CORE_DIR . 'inc/post-types.php';
require_once EGI_CORE_DIR . 'inc/meta.php';
require_once EGI_CORE_DIR . 'inc/redirects.php';
require_once EGI_CORE_DIR . 'inc/hardening.php';
require_once EGI_CORE_DIR . 'inc/editor.php';

/**
 * Flush rewrite rules on activation so /products/ resolves immediately.
 */
function egi_core_activate() {
	egi_core_register_post_types();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'egi_core_activate' );

/**
 * Flush rewrite rules on deactivation to remove the CPT rules.
 */
function egi_core_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'egi_core_deactivate' );
