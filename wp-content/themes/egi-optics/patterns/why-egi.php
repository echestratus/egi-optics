<?php
/**
 * Title: Why EGI
 * Slug: egi-optics/why-egi
 * Categories: egi-optics
 * Description: Three reasons to partner with EGI in large panels.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

$egi_optics_items = array(
	array( 'award', __( 'Proven expertise', 'egi-optics' ), __( 'Decades of combined experience in laser technology and defense-systems engineering, backed by manufacturing partners with long export records.', 'egi-optics' ) ),
	array( 'layers', __( 'End-to-end solutions', 'egi-optics' ), __( 'From consultation and system design through delivery, integration on vehicles and weapons, operator training and lifetime maintenance.', 'egi-optics' ) ),
	array( 'link', __( 'Strategic partnership', 'egi-optics' ), __( 'We invest in long-term relationships with the TNI, Polri and government agencies - dedicated support, transparent technology transfer and continuous innovation.', 'egi-optics' ) ),
);
?>
<!-- wp:group {"align":"full","className":"egi-line-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}},"color":{"gradient":"var:preset|gradient|surface-fade"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-line-top has-surface-fade-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"720px"}} -->
	<div class="wp-block-group alignwide egi-reveal" style="margin-bottom:var(--wp--preset--spacing--60)">
		<!-- wp:paragraph {"className":"egi-label"} -->
		<p class="egi-label"><?php echo esc_html__( 'Why choose EGI', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"className":"egi-balance"} -->
		<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'A strategic partner for sovereign defense technology.', 'egi-optics' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"egi-reveal-stagger","layout":{"type":"grid","minimumColumnWidth":"20rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
	<div class="wp-block-group alignwide egi-reveal-stagger">
		<?php foreach ( $egi_optics_items as $egi_optics_index => $egi_optics_item ) : ?>
		<!-- wp:group {"className":"is-style-egi-panel egi-card--accent-top","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-egi-panel egi-card--accent-top">
			<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between","verticalAlignment":"center"}} -->
			<div class="wp-block-group">
				<?php echo egi_optics_icon_block( $egi_optics_item[0], 'egi-icon egi-icon--lg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
				<!-- wp:paragraph {"className":"egi-ordinal"} -->
				<p class="egi-ordinal"><?php echo esc_html( sprintf( '%02d', $egi_optics_index + 1 ) ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|2xl"},"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--50);font-size:var(--wp--preset--font-size--2xl)"><?php echo esc_html( $egi_optics_item[1] ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html( $egi_optics_item[2] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
