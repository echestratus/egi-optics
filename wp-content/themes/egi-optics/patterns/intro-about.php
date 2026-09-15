<?php
/**
 * Title: Intro - company overview
 * Slug: egi-optics/intro-about
 * Categories: egi-optics
 * Description: Two-column introduction with headline, copy, key facts and a framed image.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-reveal" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|80"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
			<!-- wp:paragraph {"className":"egi-label"} -->
			<p class="egi-label"><?php echo esc_html__( 'Who we are', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"className":"egi-balance"} -->
			<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Optical superiority, built and supported at home.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"egi-lead"} -->
			<p class="egi-lead"><?php echo esc_html__( 'Founded in 2020, PT EGI Optik Indonesia is a trusted supplier of laser, electro-optical, thermal and night-vision systems for Indonesia\'s armed forces. We combine proven technology from Eastern European partners such as LEMT with local assembly, calibration and training - so every system arrives mission-ready and stays that way.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"is-style-egi-check","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<ul class="wp-block-list is-style-egi-check" style="margin-top:var(--wp--preset--spacing--50)">
				<!-- wp:list-item --><li><?php echo esc_html__( 'ISO 14644-1 Class 7 clean-room assembly facility in Cikarang, Bekasi', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( 'Field-proven with Indonesian special forces and presidential security units', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( '24/7 support desk, free calibration and comprehensive operator training', 'egi-optics' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
				<!-- wp:button {"className":"is-style-egi-ghost"} -->
				<div class="wp-block-button is-style-egi-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php echo esc_html__( 'More about EGI Optik Indonesia', 'egi-optics' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
			<!-- wp:group {"className":"egi-hud","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-hud">
				<!-- wp:image {"sizeSlug":"large","className":"is-style-egi-plain egi-media-frame"} -->
				<figure class="wp-block-image size-large is-style-egi-plain egi-media-frame"><img src="<?php echo esc_url( egi_optics_asset( 'img/hero-optics.jpg' ) ); ?>" alt="<?php echo esc_attr__( 'Laser weapon system and laser aiming module on an optical engineering bench', 'egi-optics' ); ?>"/></figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
