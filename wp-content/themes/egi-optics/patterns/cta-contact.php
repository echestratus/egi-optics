<?php
/**
 * Title: Call to action - contact
 * Slug: egi-optics/cta-contact
 * Categories: egi-optics
 * Description: Full-width closing band with headline, supporting copy and two buttons.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-cta egi-grid-bg egi-line-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|90","bottom":"var:preset|spacing|90"}},"color":{"gradient":"var:preset|gradient|surface-rise"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-cta egi-grid-bg egi-line-top has-surface-rise-gradient-background has-background" style="padding-top:var(--wp--preset--spacing--90);padding-bottom:var(--wp--preset--spacing--90)">
	<!-- wp:group {"className":"egi-reveal","layout":{"type":"constrained","contentSize":"820px"}} -->
	<div class="wp-block-group egi-reveal">
		<!-- wp:paragraph {"align":"center","className":"egi-label egi-label--dot"} -->
		<p class="has-text-align-center egi-label egi-label--dot"><?php echo esc_html__( 'Let\'s collaborate', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","className":"egi-balance","style":{"typography":{"fontSize":"var:preset|font-size|display"}}} -->
		<h2 class="wp-block-heading has-text-align-center egi-balance" style="font-size:var(--wp--preset--font-size--display)"><?php echo esc_html__( 'Ready to see the systems in action?', 'egi-optics' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center","className":"egi-lead"} -->
		<p class="has-text-align-center egi-lead"><?php echo esc_html__( 'We arrange live demonstrations for defense and security agencies, provide technical briefings and support procurement teams from specification to delivery.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html__( 'Request a demonstration', 'egi-optics' ); ?></a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"is-style-egi-outline"} -->
			<div class="wp-block-button is-style-egi-outline"><a class="wp-block-button__link wp-element-button" href="mailto:support@egi-optics.com"><?php echo esc_html__( 'support@egi-optics.com', 'egi-optics' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
