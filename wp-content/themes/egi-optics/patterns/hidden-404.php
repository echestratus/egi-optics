<?php
/**
 * Title: 404 content
 * Slug: egi-optics/hidden-404
 * Inserter: no
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"className":"egi-grid-bg","style":{"spacing":{"padding":{"top":"var:preset|spacing|90","bottom":"var:preset|spacing|90"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group egi-grid-bg" style="padding-top:var(--wp--preset--spacing--90);padding-bottom:var(--wp--preset--spacing--90)">
	<!-- wp:paragraph {"align":"center","className":"egi-label egi-label--dot"} -->
	<p class="has-text-align-center egi-label egi-label--dot"><?php echo esc_html__( 'Error 404 · Target not acquired', 'egi-optics' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"textAlign":"center","level":1} -->
	<h1 class="wp-block-heading has-text-align-center"><?php echo esc_html__( 'This page is outside our field of view.', 'egi-optics' ); ?></h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","className":"egi-lead"} -->
	<p class="has-text-align-center egi-lead"><?php echo esc_html__( 'The address may have changed during our site update. Try the products catalogue, the latest news, or search below.', 'egi-optics' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--50)">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/products/' ) ); ?>"><?php echo esc_html__( 'Products', 'egi-optics' ); ?></a></div>
		<!-- /wp:button -->
		<!-- wp:button {"className":"is-style-egi-outline"} -->
		<div class="wp-block-button is-style-egi-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html__( 'Back to home', 'egi-optics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
	<!-- wp:search {"label":"<?php echo esc_attr__( 'Search', 'egi-optics' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search the site…', 'egi-optics' ); ?>","buttonText":"<?php echo esc_attr__( 'Search', 'egi-optics' ); ?>","align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}}} /-->
</div>
<!-- /wp:group -->
