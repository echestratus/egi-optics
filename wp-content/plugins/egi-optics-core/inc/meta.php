<?php
/**
 * Product meta fields (exposed to the block editor and to Block Bindings via core/post-meta).
 *
 * @package EGI_Optics_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Meta keys registered for products.
 *
 * @return array<string, array<string, mixed>> key => register_post_meta() args.
 */
function egi_core_product_meta_fields() {
	return array(
		'egi_tagline'         => array(
			'type'              => 'string',
			'description'       => __( 'Short tagline shown under the product name, e.g. "Man-portable · Anti-FPV drone".', 'egi-optics-core' ),
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => __( 'Tagline', 'egi-optics-core' ),
		),
		'egi_datasheet_url'   => array(
			'type'              => 'string',
			'description'       => __( 'URL of the downloadable PDF datasheet.', 'egi-optics-core' ),
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => __( 'Datasheet URL', 'egi-optics-core' ),
		),
		'egi_datasheet_label' => array(
			'type'              => 'string',
			'description'       => __( 'Label for the datasheet button, e.g. "Download datasheet (PDF, 2 MB)".', 'egi-optics-core' ),
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => __( 'Datasheet label', 'egi-optics-core' ),
		),
		'egi_accent'          => array(
			'type'              => 'string',
			'description'       => __( 'Palette slug used as the accent colour for this product (primary, accent, amber, emerald, violet, rose).', 'egi-optics-core' ),
			'default'           => 'primary',
			'sanitize_callback' => 'egi_core_sanitize_accent',
			'label'             => __( 'Accent colour', 'egi-optics-core' ),
		),
		'egi_badge'           => array(
			'type'              => 'string',
			'description'       => __( 'Optional badge shown on product cards, e.g. "New" or "Field-proven".', 'egi-optics-core' ),
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => __( 'Card badge', 'egi-optics-core' ),
		),
	);
}

/**
 * Allowed accent slugs (must exist in the theme palette).
 *
 * @return string[]
 */
function egi_core_accent_slugs() {
	return array( 'primary', 'accent', 'amber', 'emerald', 'violet', 'rose' );
}

/**
 * Sanitize the accent slug.
 *
 * @param string $value Raw value.
 * @return string
 */
function egi_core_sanitize_accent( $value ) {
	$value = sanitize_key( (string) $value );
	return in_array( $value, egi_core_accent_slugs(), true ) ? $value : 'primary';
}

/**
 * Register product meta so it is available in REST and to Block Bindings.
 */
function egi_core_register_meta() {
	foreach ( egi_core_product_meta_fields() as $key => $args ) {
		register_post_meta(
			EGI_CORE_PRODUCT_CPT,
			$key,
			array(
				'type'              => $args['type'],
				'description'       => $args['description'],
				'single'            => true,
				'default'           => $args['default'],
				'sanitize_callback' => $args['sanitize_callback'],
				'show_in_rest'      => true,
				'label'             => $args['label'],
				'auth_callback'     => static function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'egi_core_register_meta' );

/**
 * Editor sidebar panel ("Product details") for the meta fields.
 */
function egi_core_enqueue_editor_assets() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || EGI_CORE_PRODUCT_CPT !== $screen->post_type ) {
		return;
	}

	wp_enqueue_script(
		'egi-core-product-panel',
		EGI_CORE_URL . 'assets/js/product-panel.js',
		array( 'wp-plugins', 'wp-editor', 'wp-element', 'wp-components', 'wp-data', 'wp-core-data', 'wp-i18n' ),
		EGI_CORE_VERSION,
		true
	);

	wp_add_inline_script(
		'egi-core-product-panel',
		'window.egiCoreProduct = ' . wp_json_encode(
			array(
				'postType' => EGI_CORE_PRODUCT_CPT,
				'accents'  => egi_core_accent_slugs(),
			)
		) . ';',
		'before'
	);
	wp_set_script_translations( 'egi-core-product-panel', 'egi-optics-core' );
}
add_action( 'enqueue_block_editor_assets', 'egi_core_enqueue_editor_assets' );

/**
 * Helper for templates: get a product meta value with its default.
 *
 * @param string   $key     Meta key.
 * @param int|null $post_id Post ID (defaults to current post).
 * @return string
 */
function egi_core_get_product_meta( $key, $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$fields  = egi_core_product_meta_fields();
	if ( ! $post_id || ! isset( $fields[ $key ] ) ) {
		return '';
	}
	$value = get_post_meta( $post_id, $key, true );
	return ( '' === $value || null === $value ) ? (string) $fields[ $key ]['default'] : (string) $value;
}

/**
 * Expose the accent as a CSS custom property on the <body> of single products so
 * theme CSS can colour highlights with var(--egi-accent).
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function egi_core_product_body_class( $classes ) {
	if ( is_singular( EGI_CORE_PRODUCT_CPT ) ) {
		$classes[] = 'egi-accent-' . egi_core_get_product_meta( 'egi_accent' );
	}
	return $classes;
}
add_filter( 'body_class', 'egi_core_product_body_class' );
