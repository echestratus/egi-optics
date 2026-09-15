<?php
/**
 * Permanent (301) redirects for URLs that existed on the previous Elementor-based site.
 *
 * Keeping the map in code (instead of a plugin UI) makes every URL change reviewable in Git.
 * Add a row here whenever a published slug changes.
 *
 * @package EGI_Optics_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Legacy path => new path (both relative to the site root, with leading slash, no trailing slash).
 *
 * @return array<string, string>
 */
function egi_core_redirect_map() {
	$map = array(
		// Product pages from the 2025 site (single pages) -> Products post type.
		'/laser-gun'                               => '/products/laser-weapon-system',
		'/laser-weapon-system'                     => '/products/fenix-counter-uav-laser-complex',
		'/thermal-vision-sight'                    => '/products/thermal-vision-sight-tvd-35',
		'/night-vision'                            => '/products/night-vision-monocular-nv-m-19',
		'/laser-point'                             => '/products/laser-point-lad-21t',
		'/fusion'                                  => '/products/fusion-tn-ks-2',
		// Blog renamed to News.
		'/blog'                                    => '/news',
		'/category/uncategorized'                  => '/news',
		// Template demo pages that were removed.
		'/clients'                                 => '/about',
		'/career'                                  => '/about',
		'/locations'                               => '/contact',
		// Template demo posts that were removed.
		'/hello-world'                             => '/news',
		'/driving-success-through-expert-guidance' => '/news',
		'/top-skills-every-strategic-consultant-should-master' => '/news',
		'/why-strategic-consulting-is-the-key-to-sustainable-growth' => '/news',
		'/successful-transformations-led-by-strategic-consultants' => '/news',
		'/how-to-choose-the-right-strategic-consultant-for-your-business' => '/news',
		'/strategic-consulting-for-startups-building-a-solid-foundation' => '/news',
	);

	/**
	 * Filter the legacy redirect map.
	 *
	 * @param array<string, string> $map Legacy path => new path.
	 */
	return apply_filters( 'egi_core_redirect_map', $map );
}

/**
 * Issue the redirect very early on the front end, before WordPress renders a 404.
 */
function egi_core_handle_legacy_redirects() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- parsed and compared against a fixed allow-list below.
	$path        = wp_parse_url( $request_uri, PHP_URL_PATH );
	if ( ! is_string( $path ) || '' === $path ) {
		return;
	}

	// Normalise: strip the WordPress subdirectory (none in production), trailing slash and lowercase.
	$home_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( is_string( $home_path ) && '/' !== $home_path && 0 === strpos( $path, $home_path ) ) {
		$path = substr( $path, strlen( $home_path ) - 1 );
	}
	$path = strtolower( rtrim( $path, '/' ) );
	if ( '' === $path ) {
		return;
	}

	$map = egi_core_redirect_map();
	if ( ! isset( $map[ $path ] ) ) {
		return;
	}

	$target = home_url( user_trailingslashit( $map[ $path ] ) );
	wp_safe_redirect( $target, 301, 'EGI Optics Core' );
	exit;
}
add_action( 'template_redirect', 'egi_core_handle_legacy_redirects', 1 );
