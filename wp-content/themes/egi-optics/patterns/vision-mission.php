<?php
/**
 * Title: Vision and mission
 * Slug: egi-optics/vision-mission
 * Categories: egi-optics
 * Description: Two large statement panels for vision and mission.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-line-top egi-line-bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},"color":{"background":"rgba(11,19,43,0.4)"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-line-top egi-line-bottom has-background" style="background-color:rgba(11,19,43,0.4);padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:columns {"align":"wide","className":"egi-reveal-stagger","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50","top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide egi-reveal-stagger">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-egi-panel egi-card--glass","style":{"border":{"color":"rgba(59,130,246,0.35)"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-egi-panel egi-card--glass has-border-color" style="border-color:rgba(59,130,246,0.35)">
				<!-- wp:group {"layout":{"type":"flex","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
				<div class="wp-block-group">
					<?php echo egi_optics_icon_block( 'eye', 'egi-icon egi-icon--bare' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
					<!-- wp:paragraph {"className":"egi-label"} -->
					<p class="egi-label"><?php echo esc_html__( 'Our vision', 'egi-optics' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:heading {"level":3,"className":"egi-balance","style":{"typography":{"fontSize":"var:preset|font-size|2xl","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
				<h3 class="wp-block-heading egi-balance" style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--2xl);font-weight:500"><?php echo esc_html__( 'To become Southeast Asia\'s most trusted partner in precision laser and electro-optical defense technology - a leading, giant-scale provider of optics for the Indonesian military industry.', 'egi-optics' ); ?></h3>
				<!-- /wp:heading -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"is-style-egi-panel egi-card--glass","style":{"border":{"color":"rgba(34,211,238,0.35)"}},"layout":{"type":"constrained"}} -->
			<div class="wp-block-group is-style-egi-panel egi-card--glass has-border-color" style="border-color:rgba(34,211,238,0.35)">
				<!-- wp:group {"layout":{"type":"flex","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
				<div class="wp-block-group">
					<?php echo egi_optics_icon_block( 'target', 'egi-icon egi-icon--bare' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
					<!-- wp:paragraph {"className":"egi-label"} -->
					<p class="egi-label"><?php echo esc_html__( 'Our mission', 'egi-optics' ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<!-- wp:heading {"level":3,"className":"egi-balance","style":{"typography":{"fontSize":"var:preset|font-size|2xl","fontWeight":"500"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
				<h3 class="wp-block-heading egi-balance" style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--2xl);font-weight:500"><?php echo esc_html__( 'Delivering world-class laser systems with uncompromising quality, local expertise and end-to-end technical support - ensuring total customer satisfaction through superior products and comprehensive after-sales service.', 'egi-optics' ); ?></h3>
				<!-- /wp:heading -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
