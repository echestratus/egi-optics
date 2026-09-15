<?php
/**
 * Title: Core competencies
 * Slug: egi-optics/competencies
 * Categories: egi-optics
 * Description: Six icon cards describing core competencies.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

$egi_optics_items = array(
	array( 'sparkles', __( 'Innovation', 'egi-optics' ), __( 'Pioneering directed-energy and electro-optical solutions for emerging defense challenges, from FPV drones to night operations.', 'egi-optics' ) ),
	array( 'wrench', __( 'Engineering', 'egi-optics' ), __( 'Precision-engineered systems built to exacting standards and assembled in a certified clean-room facility.', 'egi-optics' ) ),
	array( 'shield', __( 'Reliability', 'egi-optics' ), __( 'Battle-proven technology validated in live-fire trials with Indonesian special forces for mission-critical use.', 'egi-optics' ) ),
	array( 'target', __( 'Precision', 'egi-optics' ), __( 'Sub-milliradian accuracy across laser aiming devices, weapon sights and directed-energy platforms.', 'egi-optics' ) ),
	array( 'map-pin', __( 'Local support', 'egi-optics' ), __( 'In-country technical teams for rapid deployment, calibration, maintenance and 24/7 assistance.', 'egi-optics' ) ),
	array( 'users', __( 'Professional team', 'egi-optics' ), __( 'Certified engineers with international training delivering operator courses and detailed SOPs.', 'egi-optics' ) ),
);
?>
<!-- wp:group {"align":"full","className":"egi-line-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-line-top" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"720px"}} -->
	<div class="wp-block-group alignwide egi-reveal" style="margin-bottom:var(--wp--preset--spacing--60)">
		<!-- wp:paragraph {"className":"egi-label"} -->
		<p class="egi-label"><?php echo esc_html__( 'Core competencies', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"className":"egi-balance"} -->
		<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Engineered for precision, executed for the mission.', 'egi-optics' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"egi-reveal-stagger","layout":{"type":"grid","minimumColumnWidth":"22rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
	<div class="wp-block-group alignwide egi-reveal-stagger">
		<?php foreach ( $egi_optics_items as $egi_optics_item ) : ?>
		<!-- wp:group {"className":"is-style-egi-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-egi-card">
			<?php echo egi_optics_icon_block( $egi_optics_item[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|xl"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
			<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--xl)"><?php echo esc_html( $egi_optics_item[1] ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|sm"}}} -->
			<p style="font-size:var(--wp--preset--font-size--sm)"><?php echo esc_html( $egi_optics_item[2] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
