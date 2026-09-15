<?php
/**
 * Block style variations (their CSS lives in style.css under section 7).
 *
 * @package EGI_Optics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register block styles used by the patterns.
 */
function egi_optics_register_block_styles() {
	$styles = array(
		array( 'core/table', 'egi-spec', __( 'Spec table', 'egi-optics' ) ),
		array( 'core/list', 'egi-check', __( 'Check list', 'egi-optics' ) ),
		array( 'core/list', 'egi-square', __( 'Square bullets', 'egi-optics' ) ),
		array( 'core/list', 'egi-tags', __( 'Tag chips', 'egi-optics' ) ),
		array( 'core/button', 'egi-outline', __( 'Outline', 'egi-optics' ) ),
		array( 'core/button', 'egi-ghost', __( 'Ghost (text + arrow)', 'egi-optics' ) ),
		array( 'core/group', 'egi-card', __( 'Card', 'egi-optics' ) ),
		array( 'core/group', 'egi-panel', __( 'Panel', 'egi-optics' ) ),
		array( 'core/image', 'egi-frame', __( 'Engineering frame', 'egi-optics' ) ),
		array( 'core/image', 'egi-plain', __( 'Plain (no radius)', 'egi-optics' ) ),
		array( 'core/separator', 'egi-glow', __( 'Glow line', 'egi-optics' ) ),
	);

	foreach ( $styles as $style ) {
		register_block_style(
			$style[0],
			array(
				'name'  => $style[1],
				'label' => $style[2],
			)
		);
	}
}
add_action( 'init', 'egi_optics_register_block_styles' );

/**
 * Core styles that clash with the design system are unregistered in the editor
 * (they are registered client-side, so this must run as editor JS).
 */
function egi_optics_unregister_core_block_styles() {
	wp_add_inline_script(
		'wp-blocks',
		"wp.domReady(function(){['outline'].forEach(function(s){wp.blocks.unregisterBlockStyle('core/button',s)});['rounded'].forEach(function(s){wp.blocks.unregisterBlockStyle('core/image',s)});['dots'].forEach(function(s){wp.blocks.unregisterBlockStyle('core/separator',s)});});"
	);
}
add_action( 'enqueue_block_editor_assets', 'egi_optics_unregister_core_block_styles' );
