<?php
/**
 * Title: News loop (inherits query)
 * Slug: egi-optics/news-loop
 * Categories: egi-optics
 * Description: Query Loop for archive templates: news cards with featured image, meta, title and excerpt, plus pagination.
 * Viewport Width: 1400
 * Block Types: core/query
 * Inserter: no
 *
 * @package EGI_Optics
 */

?>
<!-- wp:query {"queryId":20,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"align":"wide","className":"egi-news-query"} -->
<div class="wp-block-query alignwide egi-news-query">
	<!-- wp:post-template {"className":"egi-news-grid egi-news-grid--featured","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"20rem"}} -->
		<!-- wp:group {"className":"egi-news-card","layout":{"type":"default"}} -->
		<div class="wp-block-group egi-news-card">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","sizeSlug":"egi-card"} /-->
			<!-- wp:group {"className":"egi-news-card__body","layout":{"type":"default"}} -->
			<div class="wp-block-group egi-news-card__body">
				<!-- wp:template-part {"slug":"post-meta","area":"uncategorized"} /-->
				<!-- wp:post-title {"level":3,"isLink":true} /-->
				<!-- wp:post-excerpt {"excerptLength":24,"showMoreOnNewLine":false} /-->
				<!-- wp:read-more {"content":"<?php echo esc_attr__( 'Read article →', 'egi-optics' ); ?>","className":"egi-mono","style":{"typography":{"fontSize":"var:preset|font-size|xs","letterSpacing":"0.14em","textTransform":"uppercase"}}} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-pagination {"paginationArrow":"arrow","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
		<!-- wp:query-pagination-previous /-->
		<!-- wp:query-pagination-numbers /-->
		<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination -->

	<!-- wp:query-no-results -->
		<!-- wp:pattern {"slug":"egi-optics/hidden-no-results"} /-->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
