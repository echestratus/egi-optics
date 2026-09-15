<?php
/**
 * Title: Page header
 * Slug: egi-optics/page-header
 * Categories: egi-optics
 * Description: Inner-page header with label, headline and lead paragraph on an engineering grid.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-grid-bg egi-line-bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-grid-bg egi-line-bottom" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","className":"egi-hero__content","layout":{"type":"constrained","justifyContent":"left","contentSize":"820px"}} -->
	<div class="wp-block-group alignwide egi-hero__content">
		<!-- wp:paragraph {"className":"egi-label egi-label--dot"} -->
		<p class="egi-label egi-label--dot"><?php echo esc_html__( 'Section label', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"egi-balance"} -->
		<h1 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Page headline goes here.', 'egi-optics' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"className":"egi-lead"} -->
		<p class="egi-lead"><?php echo esc_html__( 'One or two sentences that frame the page for the reader.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
