<?php
/**
 * Title: Latest news
 * Slug: egi-optics/news-latest
 * Categories: egi-optics
 * Description: Section with the three most recent news articles and a link to the news index.
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
			<p class="egi-label"><?php echo esc_html__( 'News and events', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"className":"egi-balance"} -->
			<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Latest from the field.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-egi-ghost"} -->
			<div class="wp-block-button is-style-egi-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php echo esc_html__( 'All news', 'egi-optics' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":21,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide","className":"egi-news-query"} -->
	<div class="wp-block-query alignwide egi-news-query">
		<!-- wp:post-template {"className":"egi-news-grid egi-reveal-stagger","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"20rem"}} -->
			<!-- wp:group {"className":"egi-news-card","layout":{"type":"default"}} -->
			<div class="wp-block-group egi-news-card">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","sizeSlug":"egi-card"} /-->
				<!-- wp:group {"className":"egi-news-card__body","layout":{"type":"default"}} -->
				<div class="wp-block-group egi-news-card__body">
					<!-- wp:template-part {"slug":"post-meta","area":"uncategorized"} /-->
					<!-- wp:post-title {"level":3,"isLink":true} /-->
					<!-- wp:post-excerpt {"excerptLength":20,"showMoreOnNewLine":false} /-->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
		<!-- wp:query-no-results -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html__( 'No news has been published yet.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
