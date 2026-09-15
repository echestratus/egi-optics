<?php
/**
 * Front-end and editor assets.
 *
 * @package EGI_Optics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the theme stylesheet and the progressive-enhancement script.
 */
function egi_optics_enqueue_assets() {
	wp_enqueue_style(
		'egi-optics-style',
		get_stylesheet_uri(),
		array(),
		EGI_OPTICS_VERSION
	);

	wp_enqueue_script(
		'egi-optics-main',
		EGI_OPTICS_URI . '/assets/js/main.js',
		array(),
		EGI_OPTICS_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'egi_optics_enqueue_assets' );

/**
 * Block-specific styles that only load when the block is present on the page.
 * theme.json handles the design tokens; these files carry layout rules that
 * need selectors theme.json cannot express.
 */
function egi_optics_block_styles_assets() {
	$blocks = array(
		'core/navigation' => 'navigation',
		'core/query'      => 'query',
		'core/gallery'    => 'gallery',
	);
	foreach ( $blocks as $block => $file ) {
		$path = EGI_OPTICS_DIR . "/assets/css/blocks/{$file}.css";
		if ( ! file_exists( $path ) ) {
			continue;
		}
		wp_enqueue_block_style(
			$block,
			array(
				'handle' => "egi-optics-block-{$file}",
				'src'    => EGI_OPTICS_URI . "/assets/css/blocks/{$file}.css",
				'path'   => $path,
				'ver'    => EGI_OPTICS_VERSION,
			)
		);
	}
}
add_action( 'init', 'egi_optics_block_styles_assets' );

/**
 * Remove the classic-theme CSS that block themes do not need.
 */
function egi_optics_dequeue_legacy_styles() {
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'egi_optics_dequeue_legacy_styles', 20 );

/**
 * Add `defer` to non-critical third-party scripts that ship without a strategy.
 *
 * @param string $tag    Script tag.
 * @param string $handle Script handle.
 * @return string
 */
function egi_optics_defer_scripts( $tag, $handle ) {
	$defer = array( 'srfm-form-submit', 'srfm-form-styles' );
	if ( in_array( $handle, $defer, true ) && false === strpos( $tag, 'defer' ) ) {
		$tag = str_replace( ' src=', ' defer src=', $tag );
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'egi_optics_defer_scripts', 10, 2 );
