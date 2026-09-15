<?php
/**
 * Block pattern categories and pattern housekeeping.
 *
 * Patterns themselves live in /patterns/*.php and are auto-registered by WordPress.
 *
 * @package EGI_Optics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the theme pattern categories.
 */
function egi_optics_register_pattern_categories() {
	register_block_pattern_category(
		'egi-optics',
		array(
			'label'       => __( 'EGI Optics', 'egi-optics' ),
			'description' => __( 'Sections designed for egi-optics.com: heroes, product showcases, specification tables, videos, downloads and calls to action.', 'egi-optics' ),
		)
	);
	register_block_pattern_category(
		'egi-optics-pages',
		array(
			'label'       => __( 'EGI Optics - full pages', 'egi-optics' ),
			'description' => __( 'Complete page layouts (Home, About, Contact).', 'egi-optics' ),
		)
	);
}
add_action( 'init', 'egi_optics_register_pattern_categories', 9 );

/**
 * Hide remote (wordpress.org) patterns and the core patterns that clash with the design system,
 * so editors only see on-brand sections.
 */
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Remove core pattern categories/patterns we do not want editors to use.
 */
function egi_optics_remove_core_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'egi_optics_remove_core_patterns', 20 );
