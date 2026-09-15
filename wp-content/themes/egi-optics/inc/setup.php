<?php
/**
 * Theme supports and editor configuration.
 *
 * @package EGI_Optics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register theme supports that theme.json does not cover.
 */
function egi_optics_setup() {
	load_theme_textdomain( 'egi-optics', EGI_OPTICS_DIR . '/languages' );

	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'style.css', 'assets/css/editor.css' ) );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1600, 1200 );
	add_image_size( 'egi-card', 800, 600, false );
	add_image_size( 'egi-hero', 1920, 1080, false );

	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	// Comments are disabled by egi-optics-core; also drop the widget-era support that would show them.
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'egi_optics_setup' );

/**
 * Human readable names for the custom image sizes in the editor.
 *
 * @param array $sizes Size slugs => labels.
 * @return array
 */
function egi_optics_image_size_names( $sizes ) {
	return array_merge(
		$sizes,
		array(
			'egi-card' => __( 'Card (800px)', 'egi-optics' ),
			'egi-hero' => __( 'Hero (1920px)', 'egi-optics' ),
		)
	);
}
add_filter( 'image_size_names_choose', 'egi_optics_image_size_names' );

/**
 * Add a `js` class to <html> as early as possible so scroll-reveal styles only apply when JS runs.
 */
function egi_optics_js_class() {
	echo '<script>document.documentElement.classList.add("js");</script>' . "\n";
}
add_action( 'wp_head', 'egi_optics_js_class', 0 );

/**
 * Theme colour for mobile browser chrome.
 */
function egi_optics_meta_theme_color() {
	echo '<meta name="theme-color" content="#040814">' . "\n";
	echo '<meta name="color-scheme" content="dark">' . "\n";
}
add_action( 'wp_head', 'egi_optics_meta_theme_color', 1 );

/**
 * Preload the two primary fonts so headings do not flash.
 */
function egi_optics_preload_fonts() {
	$fonts = array(
		'assets/fonts/space-grotesk-latin-wght-normal.woff2',
		'assets/fonts/dm-sans-latin-wght-normal.woff2',
	);
	foreach ( $fonts as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( EGI_OPTICS_URI . '/' . $font )
		);
	}
}
add_action( 'wp_head', 'egi_optics_preload_fonts', 2 );

/**
 * Body classes for context-aware styling.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function egi_optics_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'egi-is-front';
	}
	if ( is_singular( 'post' ) ) {
		$classes[] = 'egi-is-article';
	}
	if ( ! wp_is_mobile() ) {
		$classes[] = 'egi-has-hover';
	}
	return $classes;
}
add_filter( 'body_class', 'egi_optics_body_classes' );

/**
 * Prefer the "News" page title over "Blog" for the posts index document title.
 *
 * @param array $title Title parts.
 * @return array
 */
function egi_optics_document_title( $title ) {
	if ( is_home() && ! is_front_page() ) {
		$title['title'] = __( 'News', 'egi-optics' );
	}
	return $title;
}
add_filter( 'document_title_parts', 'egi_optics_document_title' );
