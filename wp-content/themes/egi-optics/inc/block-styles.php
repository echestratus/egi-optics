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

	// Core "outline" button style is replaced by our own variants.
	unregister_block_style( 'core/button', 'outline' );
	unregister_block_style( 'core/image', 'rounded' );
	unregister_block_style( 'core/separator', 'dots' );
	unregister_block_style( 'core/quote', 'plain' );
}
add_action( 'init', 'egi_optics_register_block_styles' );
