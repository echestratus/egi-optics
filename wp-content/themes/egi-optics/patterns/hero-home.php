<?php
/**
 * Title: Hero - Home
 * Slug: egi-optics/hero-home
 * Categories: egi-optics
 * Description: Full-height hero with engineering backdrop, label, headline, lead text, calls to action and scroll hint.
 * Viewport Width: 1400
 * Block Types: core/cover
 *
 * @package EGI_Optics
 */

?>
<!-- wp:cover {"url":"<?php echo esc_url( egi_optics_asset( 'img/hero-optics.webp' ) ); ?>","dimRatio":60,"overlayColor":"base","isUserOverlayColor":true,"align":"full","className":"egi-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"0","right":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull egi-hero" style="padding-top:var(--wp--preset--spacing--80);padding-right:0;padding-bottom:var(--wp--preset--spacing--80);padding-left:0"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( egi_optics_asset( 'img/hero-optics.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-base-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:group {"align":"wide","className":"egi-hero__content","layout":{"type":"constrained","justifyContent":"left","contentSize":"820px"}} -->
	<div class="wp-block-group alignwide egi-hero__content">
		<!-- wp:paragraph {"className":"egi-label egi-label--dot"} -->
		<p class="egi-label egi-label--dot"><?php echo esc_html__( 'Defense subsidiary of EGI Resources · Jakarta, Indonesia', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"className":"egi-hero__title egi-balance"} -->
		<h1 class="wp-block-heading egi-hero__title egi-balance"><?php echo esc_html__( 'Precision technology for a smarter defense.', 'egi-optics' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"egi-lead","style":{"layout":{"selfStretch":"fixed","flexSize":"640px"}}} -->
		<p class="egi-lead"><?php echo esc_html__( 'EGI Optik Indonesia delivers laser weapon systems, counter-UAV complexes, electro-optical surveillance, thermal and night-vision equipment to the Indonesian military, government and industry - engineered with European partners and assembled, tested and supported in Indonesia.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|50"}}}} -->
		<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
			<!-- wp:button -->
			<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/products/' ) ); ?>"><?php echo esc_html__( 'Explore the systems', 'egi-optics' ); ?></a></div>
			<!-- /wp:button -->
			<!-- wp:button {"className":"is-style-egi-outline"} -->
			<div class="wp-block-button is-style-egi-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html__( 'Request a briefing', 'egi-optics' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->

		<!-- wp:paragraph {"className":"egi-hero__scroll","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}}} -->
		<p class="egi-hero__scroll" style="margin-top:var(--wp--preset--spacing--70)"><?php echo esc_html__( 'Scroll', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div></div>
<!-- /wp:cover -->
