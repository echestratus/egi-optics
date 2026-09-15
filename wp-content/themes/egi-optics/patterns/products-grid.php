<?php
/**
 * Title: Products grid
 * Slug: egi-optics/products-grid
 * Categories: egi-optics
 * Description: Section heading plus a Query Loop of all products as cards (image, tagline, title, excerpt, category).
 * Viewport Width: 1400
 * Block Types: core/query
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-line-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-line-top" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide egi-reveal" style="margin-bottom:var(--wp--preset--spacing--60)">
		<!-- wp:group {"layout":{"type":"constrained","justifyContent":"left","contentSize":"720px"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"className":"egi-label"} -->
			<p class="egi-label"><?php echo esc_html__( 'Product catalogue', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"className":"egi-balance"} -->
			<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'The laser and electro-optical defense portfolio.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-egi-ghost"} -->
			<div class="wp-block-button is-style-egi-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/products/' ) ); ?>"><?php echo esc_html__( 'View all products', 'egi-optics' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":10,"query":{"perPage":9,"pages":0,"offset":0,"postType":"egi_product","order":"asc","orderBy":"menu_order","author":"","search":"","exclude":[],"sticky":"","inherit":false},"align":"wide","className":"egi-products-query"} -->
	<div class="wp-block-query alignwide egi-products-query">
		<!-- wp:post-template {"className":"egi-reveal-stagger","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"22rem"}} -->
			<!-- wp:group {"className":"egi-product-card","layout":{"type":"default"}} -->
			<div class="wp-block-group egi-product-card">
				<!-- wp:group {"className":"egi-product-card__media","layout":{"type":"default"}} -->
				<div class="wp-block-group egi-product-card__media">
					<!-- wp:post-featured-image {"aspectRatio":"4/3","sizeSlug":"egi-card"} /-->
				</div>
				<!-- /wp:group -->
				<!-- wp:group {"className":"egi-product-card__body","layout":{"type":"default"}} -->
				<div class="wp-block-group egi-product-card__body">
					<!-- wp:paragraph {"className":"egi-product-tagline","metadata":{"bindings":{"content":{"source":"core/post-meta","args":{"key":"egi_tagline"}}}}} -->
					<p class="egi-product-tagline"></p>
					<!-- /wp:paragraph -->
					<!-- wp:post-title {"level":3,"isLink":true} /-->
					<!-- wp:post-excerpt {"excerptLength":20,"showMoreOnNewLine":false} /-->
					<!-- wp:group {"className":"egi-product-card__footer","layout":{"type":"flex","justifyContent":"space-between"}} -->
					<div class="wp-block-group egi-product-card__footer">
						<!-- wp:post-terms {"term":"product_category"} /-->
						<!-- wp:paragraph {"className":"egi-product-card__cta"} -->
						<p class="egi-product-card__cta"><?php echo esc_html__( 'Details →', 'egi-optics' ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
		<!-- wp:query-no-results -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html__( 'Products will appear here once they are published.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
