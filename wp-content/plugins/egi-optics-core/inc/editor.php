<?php
/**
 * Editor and front-end helpers: site info block bindings, excerpt tweaks.
 *
 * @package EGI_Optics_Core
 */

defined( 'ABSPATH' ) || exit;

/**
 * Company facts used across templates (footer, contact cards, schema).
 * Stored in the `egi_site_info` option so they can be changed with WP-CLI without a deploy;
 * defaults keep the theme working on a fresh install.
 *
 * @return array<string, string>
 */
function egi_core_site_info() {
	$defaults = array(
		'company'       => 'PT EGI Optik Indonesia',
		'short_name'    => 'EGI Optik Indonesia',
		'tagline'       => __( 'Precision Laser and Electro-Optical Defense Systems', 'egi-optics-core' ),
		'address'       => 'Oscorp Building, Jl. Dharmawangsa Raya No. 16, Kebayoran Baru, South Jakarta 12160, Indonesia',
		'address_short' => 'Jl. Dharmawangsa Raya No. 16, Kebayoran Baru, Jakarta Selatan',
		'phone'         => '+62 21 3062 9515',
		'phone_link'    => '+622130629515',
		'mobile'        => '+62 878-8770-7139',
		'mobile_link'   => '+6287887707139',
		'email'         => 'support@egi-optics.com',
		'facility'      => 'ISO 14644-1 Class 7 clean-room facility, Cikarang, Bekasi',
		'holding_name'  => 'EGI Resources',
		'holding_url'   => 'https://egiresources.com',
		'founded'       => '2020',
	);

	$stored = get_option( 'egi_site_info', array() );
	$info   = wp_parse_args( is_array( $stored ) ? $stored : array(), $defaults );

	/**
	 * Filter company facts.
	 *
	 * @param array<string, string> $info Site info.
	 */
	return apply_filters( 'egi_core_site_info', $info );
}

/**
 * Resolve a site-info key for the Block Bindings API.
 *
 * @param array         $source_args    Binding args (expects `key`).
 * @param WP_Block|null $block_instance Block being rendered (gives us postId context).
 * @return string|null
 */
function egi_core_site_binding_value( $source_args, $block_instance = null ) {
	$key = isset( $source_args['key'] ) ? sanitize_key( $source_args['key'] ) : '';
	if ( '' === $key ) {
		return null;
	}

	$info    = egi_core_site_info();
	$post_id = ( $block_instance instanceof WP_Block && isset( $block_instance->context['postId'] ) ) ? (int) $block_instance->context['postId'] : get_the_ID();

	switch ( $key ) {
		case 'year':
			return wp_date( 'Y' );
		case 'contact_url':
			// Link to the contact page pre-filled with the current product name.
			$title = $post_id ? get_the_title( $post_id ) : '';
			return add_query_arg( 'product', rawurlencode( wp_strip_all_tags( $title ) ), home_url( '/contact/' ) );
		case 'product_category':
			$terms = $post_id ? get_the_terms( $post_id, EGI_CORE_PRODUCT_TAX ) : array();
			return ( is_array( $terms ) && $terms ) ? $terms[0]->name : __( 'Product', 'egi-optics-core' );
		case 'copyright':
			/* translators: 1: current year, 2: company name. */
			return sprintf( __( '&copy; %1$s %2$s. All rights reserved.', 'egi-optics-core' ), wp_date( 'Y' ), $info['company'] );
		case 'phone_href':
			return 'tel:' . $info['phone_link'];
		case 'mobile_href':
			return 'tel:' . $info['mobile_link'];
		case 'whatsapp_href':
			return 'https://wa.me/' . ltrim( $info['mobile_link'], '+' );
		case 'email_href':
			return 'mailto:' . $info['email'];
		default:
			return isset( $info[ $key ] ) ? (string) $info[ $key ] : null;
	}
}

/**
 * Register the `egi/site` block bindings source (WordPress 6.5+).
 * Usage in block markup:
 * <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"egi/site","args":{"key":"copyright"}}}}} -->
 */
function egi_core_register_bindings() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}
	register_block_bindings_source(
		'egi/site',
		array(
			'label'              => __( 'EGI site info', 'egi-optics-core' ),
			'get_value_callback' => 'egi_core_site_binding_value',
			'uses_context'       => array( 'postId', 'postType' ),
		)
	);
}
add_action( 'init', 'egi_core_register_bindings' );

/**
 * Shorter excerpts for cards.
 *
 * @return int
 */
function egi_core_excerpt_length() {
	return 28;
}
add_filter( 'excerpt_length', 'egi_core_excerpt_length', 999 );

/**
 * Cleaner "read more" ellipsis.
 *
 * @return string
 */
function egi_core_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'egi_core_excerpt_more' );

/**
 * Register the "News" category on activation-like init if missing, so templates can rely on it.
 */
function egi_core_ensure_news_category() {
	if ( wp_installing() || ! taxonomy_exists( 'category' ) ) {
		return;
	}
	if ( get_transient( 'egi_core_news_cat_checked' ) ) {
		return;
	}
	if ( ! term_exists( 'news', 'category' ) ) {
		wp_insert_term( __( 'News', 'egi-optics-core' ), 'category', array( 'slug' => 'news' ) );
	}
	set_transient( 'egi_core_news_cat_checked', 1, DAY_IN_SECONDS );
}
add_action( 'init', 'egi_core_ensure_news_category', 20 );

/**
 * Organisation schema for the home page (Rank Math handles per-page schema; this adds the
 * company-level facts the SEO plugin does not know about).
 */
function egi_core_organization_schema() {
	if ( ! is_front_page() ) {
		return;
	}
	$info   = egi_core_site_info();
	$logo   = get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( (int) get_theme_mod( 'custom_logo' ), 'full' ) : '';
	$schema = array(
		'@context'           => 'https://schema.org',
		'@type'              => 'Organization',
		'name'               => $info['company'],
		'alternateName'      => $info['short_name'],
		'url'                => home_url( '/' ),
		'logo'               => $logo,
		'foundingDate'       => $info['founded'],
		'parentOrganization' => array(
			'@type' => 'Organization',
			'name'  => $info['holding_name'],
			'url'   => $info['holding_url'],
		),
		'address'            => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Oscorp Building, Jl. Dharmawangsa Raya No. 16',
			'addressLocality' => 'Jakarta Selatan',
			'postalCode'      => '12160',
			'addressCountry'  => 'ID',
		),
		'contactPoint'       => array(
			array(
				'@type'             => 'ContactPoint',
				'contactType'       => 'sales',
				'telephone'         => $info['phone'],
				'email'             => $info['email'],
				'areaServed'        => 'ID',
				'availableLanguage' => array( 'en', 'id' ),
			),
		),
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'egi_core_organization_schema', 20 );
