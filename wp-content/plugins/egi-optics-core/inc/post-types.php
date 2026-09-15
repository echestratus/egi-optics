<?php
/**
 * Products post type and product category taxonomy.
 *
 * @package EGI_Optics_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the Product post type and its taxonomy.
 */
function egi_core_register_post_types() {
	$labels = array(
		'name'                  => _x( 'Products', 'post type general name', 'egi-optics-core' ),
		'singular_name'         => _x( 'Product', 'post type singular name', 'egi-optics-core' ),
		'menu_name'             => _x( 'Products', 'admin menu', 'egi-optics-core' ),
		'name_admin_bar'        => _x( 'Product', 'add new on admin bar', 'egi-optics-core' ),
		'add_new'               => __( 'Add New', 'egi-optics-core' ),
		'add_new_item'          => __( 'Add New Product', 'egi-optics-core' ),
		'new_item'              => __( 'New Product', 'egi-optics-core' ),
		'edit_item'             => __( 'Edit Product', 'egi-optics-core' ),
		'view_item'             => __( 'View Product', 'egi-optics-core' ),
		'view_items'            => __( 'View Products', 'egi-optics-core' ),
		'all_items'             => __( 'All Products', 'egi-optics-core' ),
		'search_items'          => __( 'Search Products', 'egi-optics-core' ),
		'not_found'             => __( 'No products found.', 'egi-optics-core' ),
		'not_found_in_trash'    => __( 'No products found in Trash.', 'egi-optics-core' ),
		'featured_image'        => __( 'Product image', 'egi-optics-core' ),
		'set_featured_image'    => __( 'Set product image', 'egi-optics-core' ),
		'remove_featured_image' => __( 'Remove product image', 'egi-optics-core' ),
		'use_featured_image'    => __( 'Use as product image', 'egi-optics-core' ),
		'archives'              => __( 'Product archive', 'egi-optics-core' ),
		'item_published'        => __( 'Product published.', 'egi-optics-core' ),
		'item_updated'          => __( 'Product updated.', 'egi-optics-core' ),
		'item_link'             => __( 'Product link', 'egi-optics-core' ),
		'item_link_description' => __( 'A link to a product.', 'egi-optics-core' ),
	);

	register_post_type(
		EGI_CORE_PRODUCT_CPT,
		array(
			'labels'              => $labels,
			'description'         => __( 'Laser, electro-optical, thermal and night-vision systems offered by EGI Optik Indonesia.', 'egi-optics-core' ),
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'           => 'products',
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-visibility',
			'has_archive'         => 'products',
			'rewrite'             => array(
				'slug'       => 'products',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
			'hierarchical'        => false,
			'exclude_from_search' => false,
			'template'            => array(
				array( 'core/pattern', array( 'slug' => 'egi-optics/product-body' ) ),
			),
			'template_lock'       => false,
		)
	);

	$tax_labels = array(
		'name'              => _x( 'Product Categories', 'taxonomy general name', 'egi-optics-core' ),
		'singular_name'     => _x( 'Product Category', 'taxonomy singular name', 'egi-optics-core' ),
		'search_items'      => __( 'Search Product Categories', 'egi-optics-core' ),
		'all_items'         => __( 'All Product Categories', 'egi-optics-core' ),
		'parent_item'       => __( 'Parent Category', 'egi-optics-core' ),
		'parent_item_colon' => __( 'Parent Category:', 'egi-optics-core' ),
		'edit_item'         => __( 'Edit Product Category', 'egi-optics-core' ),
		'update_item'       => __( 'Update Product Category', 'egi-optics-core' ),
		'add_new_item'      => __( 'Add New Product Category', 'egi-optics-core' ),
		'new_item_name'     => __( 'New Product Category Name', 'egi-optics-core' ),
		'menu_name'         => __( 'Categories', 'egi-optics-core' ),
	);

	register_taxonomy(
		EGI_CORE_PRODUCT_TAX,
		array( EGI_CORE_PRODUCT_CPT ),
		array(
			'labels'            => $tax_labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'rest_base'         => 'product-categories',
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'product-category',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'egi_core_register_post_types' );

/**
 * Order the product archive by menu_order then title so editors control the sequence
 * with the "Order" attribute instead of publication date.
 *
 * @param WP_Query $query The main query.
 */
function egi_core_product_archive_order( WP_Query $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( EGI_CORE_PRODUCT_CPT ) || $query->is_tax( EGI_CORE_PRODUCT_TAX ) ) {
		$query->set(
			'orderby',
			array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			)
		);
		$query->set( 'posts_per_page', 24 );
	}
}
add_action( 'pre_get_posts', 'egi_core_product_archive_order' );

/**
 * Let Query Loop blocks that target products inherit the same ordering when they ask for menu_order.
 * (Query Loop already supports orderBy menu_order; this only guarantees a stable secondary key.)
 *
 * @param array $args  WP_Query arguments.
 * @param array $block Block context (unused).
 * @return array
 */
function egi_core_query_loop_product_order( $args, $block ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	if ( isset( $args['post_type'] ) && EGI_CORE_PRODUCT_CPT === $args['post_type'] && isset( $args['orderby'] ) && 'menu_order' === $args['orderby'] ) {
		$args['orderby'] = array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		);
		unset( $args['order'] );
	}
	return $args;
}
add_filter( 'query_loop_block_query_vars', 'egi_core_query_loop_product_order', 10, 2 );
