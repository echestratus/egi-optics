<?php
/**
 * Title: Field trial video
 * Slug: egi-optics/field-trial-video
 * Categories: egi-optics
 * Description: Video showcase with HUD-style frame, status label, meta chips and caption. Replace the video and texts.
 * Viewport Width: 1400
 * Block Types: core/video
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"className":"egi-video-section egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group egi-video-section egi-reveal" style="margin-top:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide" style="margin-bottom:var(--wp--preset--spacing--50)">
		<!-- wp:group {"layout":{"type":"constrained","justifyContent":"left","contentSize":"640px"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"egi-label egi-pulse"} -->
			<p class="egi-label egi-pulse"><?php echo esc_html__( 'Field trial footage', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|xxxl"}}} -->
			<h3 class="wp-block-heading" style="font-size:var(--wp--preset--font-size--xxxl)"><?php echo esc_html__( 'Live-fire demonstration', 'egi-optics' ); ?></h3>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
		<div class="wp-block-group">
			<!-- wp:group {"className":"egi-meta-chip","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-meta-chip">
				<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Unit', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"egi-mono"} --><p class="egi-mono"><?php echo esc_html__( 'TNI', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:group {"className":"egi-meta-chip","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-meta-chip">
				<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Test type', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"egi-mono"} --><p class="egi-mono"><?php echo esc_html__( 'Live-fire', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:group {"className":"egi-meta-chip","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-meta-chip">
				<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Status', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"egi-mono"} --><p class="egi-mono"><?php echo esc_html__( 'Passed', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"egi-hud","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide egi-hud">
		<!-- wp:group {"className":"egi-video","layout":{"type":"default"}} -->
		<div class="wp-block-group egi-video">
			<!-- wp:html -->
			<div class="egi-video__bar" aria-hidden="true"><span><?php echo esc_html__( 'REC · Field trial', 'egi-optics' ); ?></span><span><?php echo esc_html__( 'EGI Optik Indonesia', 'egi-optics' ); ?></span></div>
			<!-- /wp:html -->
			<!-- wp:video {"preload":"metadata"} -->
			<figure class="wp-block-video"><video controls preload="metadata" playsinline src=""></video></figure>
			<!-- /wp:video -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
	<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php echo egi_optics_icon_block( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
		<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill"}}} -->
		<p><?php echo esc_html__( 'Describe what the footage shows: unit, conditions, targets engaged and the result. Keep it to two or three sentences.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
