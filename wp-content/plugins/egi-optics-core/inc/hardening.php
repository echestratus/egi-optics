<?php
/**
 * Lightweight security and hygiene hardening.
 *
 * Complements Solid Security (which handles brute-force protection, file permission checks,
 * and .htaccess tweaks) with code-level defaults that should survive plugin changes.
 *
 * @package EGI_Optics_Core
 */

defined( 'ABSPATH' ) || exit;

// XML-RPC is not used (no Jetpack / mobile app) and is a common brute-force vector.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );

// Do not advertise the WordPress version.
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// Remove discovery links and legacy editor manifests nobody uses.
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Emoji detection script is dead weight for a corporate site.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
add_filter( 'emoji_svg_url', '__return_false' );

/**
 * Comments and pingbacks are disabled site-wide (corporate site, no discussion).
 */
function egi_core_disable_comments() {
	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'init', 'egi_core_disable_comments', 100 );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 20 );

/**
 * Hide the Comments menu and admin-bar node.
 */
function egi_core_hide_comments_ui() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'egi_core_hide_comments_ui' );

/**
 * Remove the comments node from the admin bar.
 *
 * @param WP_Admin_Bar $wp_admin_bar Admin bar instance.
 */
function egi_core_hide_comments_admin_bar( WP_Admin_Bar $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'comments' );
}
add_action( 'admin_bar_menu', 'egi_core_hide_comments_admin_bar', 999 );

/**
 * Author archives leak usernames (/?author=1 -> /author/username/). Redirect them home.
 */
function egi_core_disable_author_archives() {
	if ( is_author() && ! is_admin() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'egi_core_disable_author_archives' );

/**
 * Do not expose the users endpoint to anonymous REST clients.
 *
 * @param array $endpoints Registered REST endpoints.
 * @return array
 */
function egi_core_restrict_users_endpoint( $endpoints ) {
	if ( is_user_logged_in() ) {
		return $endpoints;
	}
	unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	return $endpoints;
}
add_filter( 'rest_endpoints', 'egi_core_restrict_users_endpoint' );

/**
 * Baseline security headers (LiteSpeed/hPanel may add more; duplicates are harmless).
 */
function egi_core_security_headers() {
	if ( headers_sent() || is_admin() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()' );
}
add_action( 'send_headers', 'egi_core_security_headers' );

/**
 * Login errors should not reveal whether the username or the password was wrong.
 *
 * @return string
 */
function egi_core_generic_login_error() {
	return esc_html__( 'Invalid login credentials.', 'egi-optics-core' );
}
add_filter( 'login_errors', 'egi_core_generic_login_error' );

/**
 * Only allow safe upload types (defence content is images, video, PDF).
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function egi_core_upload_mimes( $mimes ) {
	$mimes['webp'] = 'image/webp';
	$mimes['avif'] = 'image/avif';
	$mimes['svg']  = 'image/svg+xml'; // Logos only; uploads are restricted to administrators below.
	unset( $mimes['exe'], $mimes['msi'], $mimes['swf'] );
	return $mimes;
}
add_filter( 'upload_mimes', 'egi_core_upload_mimes' );

/**
 * Restrict SVG uploads to administrators (SVG can carry scripts).
 *
 * @param array $data File data from wp_check_filetype_and_ext().
 * @return array
 */
function egi_core_restrict_svg( $data ) {
	if ( isset( $data['type'] ) && 'image/svg+xml' === $data['type'] && ! current_user_can( 'manage_options' ) ) {
		$data['ext']  = false;
		$data['type'] = false;
	}
	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'egi_core_restrict_svg' );
