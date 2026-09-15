<?php
/**
 * Small helpers used by patterns and templates.
 *
 * @package EGI_Optics
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL of a theme asset.
 *
 * @param string $path Path relative to /assets.
 * @return string
 */
function egi_optics_asset( $path ) {
	return EGI_OPTICS_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Markup for an inline theme icon (SVG in /assets/img/icons) rendered through a CSS mask so it
 * inherits the current accent colour. Returned as a core/html block for use inside patterns.
 *
 * @param string $name  Icon file name without extension.
 * @param string $class Wrapper class (egi-icon, egi-icon egi-icon--lg ...).
 * @return string Block markup ready to echo in a pattern.
 */
function egi_optics_icon_block( $name, $class = 'egi-icon' ) {
	return '<!-- wp:html -->' . egi_optics_icon_html( $name, $class ) . '<!-- /wp:html -->';
}

/**
 * Raw HTML for a masked theme icon.
 *
 * @param string $name  Icon file name without extension.
 * @param string $class Wrapper class.
 * @return string
 */
function egi_optics_icon_html( $name, $class = 'egi-icon' ) {
	$src = egi_optics_asset( 'img/icons/' . sanitize_file_name( $name ) . '.svg' );
	return sprintf(
		'<span class="%1$s" aria-hidden="true"><i class="egi-icon__glyph" style="--egi-icon:url(%2$s)"></i></span>',
		esc_attr( $class ),
		esc_url( $src )
	);
}

/**
 * Resolve navigation menus by slug instead of hard-coded post IDs so template parts stay
 * portable between local, staging and production.
 *
 * Usage in a template part: <!-- wp:navigation {"className":"egi-nav-primary"} /-->
 * The theme looks for a wp_navigation post named "primary" (egi-nav-<slug>).
 *
 * @param array $parsed_block Parsed block.
 * @return array
 */
function egi_optics_navigation_ref_by_slug( $parsed_block ) {
	if ( 'core/navigation' !== $parsed_block['blockName'] || ! empty( $parsed_block['attrs']['ref'] ) ) {
		return $parsed_block;
	}
	$class = isset( $parsed_block['attrs']['className'] ) ? $parsed_block['attrs']['className'] : '';
	if ( ! preg_match( '/egi-nav-([a-z0-9-]+)/', $class, $m ) ) {
		return $parsed_block;
	}

	$slug  = $m[1];
	$cache = wp_cache_get( 'egi_nav_' . $slug, 'egi-optics' );
	if ( false === $cache ) {
		$found = get_posts(
			array(
				'post_type'              => 'wp_navigation',
				'name'                   => $slug,
				'post_status'            => 'publish',
				'numberposts'            => 1,
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		);
		$cache = $found ? (int) $found[0] : 0;
		wp_cache_set( 'egi_nav_' . $slug, $cache, 'egi-optics', HOUR_IN_SECONDS );
	}

	if ( $cache ) {
		$parsed_block['attrs']['ref'] = $cache;
	}
	return $parsed_block;
}
add_filter( 'render_block_data', 'egi_optics_navigation_ref_by_slug' );

/**
 * Clear the navigation lookup cache when menus are saved.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function egi_optics_flush_nav_cache( $post_id, $post ) {
	if ( 'wp_navigation' === $post->post_type ) {
		wp_cache_delete( 'egi_nav_' . $post->post_name, 'egi-optics' );
	}
}
add_action( 'save_post_wp_navigation', 'egi_optics_flush_nav_cache', 10, 2 );

/**
 * Add the product accent class to Query Loop items so cards pick up var(--egi-accent).
 *
 * @param string[] $classes Post classes.
 * @param string[] $class   Additional classes (unused).
 * @param int      $post_id Post ID.
 * @return string[]
 */
function egi_optics_product_post_class( $classes, $class, $post_id ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( 'egi_product' === get_post_type( $post_id ) && function_exists( 'egi_core_get_product_meta' ) ) {
		$classes[] = 'egi-accent-' . egi_core_get_product_meta( 'egi_accent', $post_id );
	}
	return $classes;
}
add_filter( 'post_class', 'egi_optics_product_post_class', 10, 3 );

/**
 * Products and news should produce good automatic excerpts even when the editor forgets one:
 * strip pattern chrome (labels, stats) so the first real paragraph is used.
 *
 * @param string  $excerpt Generated excerpt.
 * @param WP_Post $post    Post.
 * @return string
 */
function egi_optics_clean_auto_excerpt( $excerpt, $post ) {
	if ( '' !== trim( (string) $post->post_excerpt ) ) {
		return $excerpt;
	}
	if ( ! in_array( $post->post_type, array( 'egi_product', 'post' ), true ) ) {
		return $excerpt;
	}
	$blocks = parse_blocks( $post->post_content );
	$text   = egi_optics_first_paragraph( $blocks );
	if ( '' === $text ) {
		return $excerpt;
	}
	return wp_trim_words( wp_strip_all_tags( $text ), 28, '&hellip;' );
}
add_filter( 'get_the_excerpt', 'egi_optics_clean_auto_excerpt', 9, 2 );

/**
 * Depth-first search for the first non-label paragraph in parsed blocks.
 *
 * @param array $blocks Parsed blocks.
 * @return string
 */
function egi_optics_first_paragraph( $blocks ) {
	foreach ( $blocks as $block ) {
		if ( 'core/paragraph' === $block['blockName'] ) {
			$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
			if ( false === strpos( $class, 'egi-label' ) && false === strpos( $class, 'egi-stat' ) && false === strpos( $class, 'egi-product-tagline' ) ) {
				$text = trim( wp_strip_all_tags( $block['innerHTML'] ) );
				if ( strlen( $text ) > 40 ) {
					return $text;
				}
			}
		}
		if ( ! empty( $block['innerBlocks'] ) ) {
			$found = egi_optics_first_paragraph( $block['innerBlocks'] );
			if ( '' !== $found ) {
				return $found;
			}
		}
	}
	return '';
}

/**
 * Open external links in the footer/holding badge in a new tab safely.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Block data.
 * @return string
 */
function egi_optics_external_links( $block_content, $block ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'egi-external' ) ) {
		return $block_content;
	}
	return str_replace( '<a ', '<a target="_blank" rel="noopener noreferrer" ', $block_content );
}
add_filter( 'render_block_core/paragraph', 'egi_optics_external_links', 10, 2 );
add_filter( 'render_block_core/button', 'egi_optics_external_links', 10, 2 );

/**
 * "Related products" loops on a single product must not include the product being viewed.
 *
 * @param array    $query Query vars.
 * @param WP_Block $block Query block.
 * @return array
 */
function egi_optics_related_products_query( $query, $block ) {
	// The filter runs for the inner post-template block; the Query block passes queryId via context.
	// queryId 40 is reserved for the "Related products" loop in templates/single-egi_product.html.
	$query_id = isset( $block->context['queryId'] ) ? (int) $block->context['queryId'] : 0;
	if ( 40 === $query_id && is_singular( 'egi_product' ) ) {
		$query['post__not_in'] = array( get_queried_object_id() );
	}
	return $query;
}
add_filter( 'query_loop_block_query_vars', 'egi_optics_related_products_query', 10, 2 );

/**
 * Hide the datasheet button when the product has no datasheet URL (bound value is empty).
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Block data.
 * @return string
 */
function egi_optics_hide_empty_datasheet_button( $block_content, $block ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'egi-datasheet-btn' ) ) {
		return $block_content;
	}
	if ( preg_match( '/href="(#|)"/', $block_content ) || false === strpos( $block_content, 'href=' ) ) {
		return '';
	}
	if ( false !== strpos( $block_content, '.pdf' ) && false === strpos( $block_content, 'target=' ) ) {
		$block_content = str_replace( '<a ', '<a target="_blank" rel="noopener" ', $block_content );
	}
	return $block_content;
}
add_filter( 'render_block_core/button', 'egi_optics_hide_empty_datasheet_button', 20, 2 );

/**
 * Give the hero image priority and avoid lazy loading it.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Block data.
 * @return string
 */
function egi_optics_eager_hero_image( $block_content, $block ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'egi-hero' ) ) {
		return $block_content;
	}
	$block_content = str_replace( ' loading="lazy"', ' fetchpriority="high"', $block_content );
	return $block_content;
}
add_filter( 'render_block_core/cover', 'egi_optics_eager_hero_image', 10, 2 );
