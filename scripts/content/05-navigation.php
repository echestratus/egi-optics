<?php
/**
 * 05 - Navigation menus (wp_navigation posts resolved by slug in the theme).
 *
 * Run: wp eval-file scripts/content/05-navigation.php   (after 03 and 04)
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

egi_content_log( '== 05 navigation ==' );

/**
 * Navigation link block markup.
 *
 * @param string $label Label.
 * @param string $url   URL.
 * @param int    $id    Object ID (page/post) or 0 for custom links.
 * @param string $kind  page|post|egi_product|custom.
 * @param string $inner Submenu markup (optional).
 * @return string
 */
function egi_content_nav_link( $label, $url, $id = 0, $kind = 'custom', $inner = '' ) {
	$attrs = array(
		'label' => $label,
		'url'   => $url,
		'kind'  => 'custom' === $kind ? 'custom' : 'post-type',
	);
	if ( $id ) {
		$attrs['id']   = $id;
		$attrs['type'] = $kind;
	}
	if ( $inner ) {
		return '<!-- wp:navigation-submenu ' . wp_json_encode( $attrs ) . ' -->' . $inner . '<!-- /wp:navigation-submenu -->';
	}
	return '<!-- wp:navigation-link ' . wp_json_encode( $attrs ) . ' /-->';
}

/**
 * Link markup for a page by slug (falls back to a custom URL).
 *
 * @param string $slug  Page slug.
 * @param string $label Label.
 * @param string $inner Optional submenu.
 * @return string
 */
function egi_content_nav_page( $slug, $label, $inner = '' ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $page ) {
		return egi_content_nav_link( $label, get_permalink( $page ), $page->ID, 'page', $inner );
	}
	return egi_content_nav_link( $label, home_url( '/' . $slug . '/' ), 0, 'custom', $inner );
}

// Products submenu from published products in menu order.
$egi_products      = get_posts(
	array(
		'post_type'   => 'egi_product',
		'post_status' => 'publish',
		'numberposts' => 12,
		'orderby'     => 'menu_order title',
		'order'       => 'ASC',
	)
);
$egi_product_links = '';
foreach ( $egi_products as $egi_p ) {
	$egi_product_links .= egi_content_nav_link( $egi_p->post_title, get_permalink( $egi_p ), $egi_p->ID, 'egi_product' );
}

$egi_primary = egi_content_nav_page( 'home', 'Home' )
	. egi_content_nav_page( 'about', 'About' )
	. egi_content_nav_link( 'Products', get_post_type_archive_link( 'egi_product' ), 0, 'custom', $egi_product_links )
	. egi_content_nav_page( 'news', 'News' )
	. egi_content_nav_page( 'contact', 'Contact' );

$egi_footer = egi_content_nav_page( 'about', 'About us' )
	. egi_content_nav_link( 'Products', get_post_type_archive_link( 'egi_product' ) )
	. egi_content_nav_page( 'news', 'News' )
	. egi_content_nav_page( 'contact', 'Contact' )
	. egi_content_nav_link( 'EGI Resources', 'https://egiresources.com' );

foreach ( array(
	'primary' => array( 'Primary navigation', $egi_primary ),
	'footer'  => array( 'Footer navigation', $egi_footer ),
) as $egi_slug => $egi_nav ) {
	egi_content_upsert_post(
		array(
			'post_type'    => 'wp_navigation',
			'post_name'    => $egi_slug,
			'post_title'   => $egi_nav[0],
			'post_content' => $egi_nav[1],
			'post_status'  => 'publish',
		)
	);
	wp_cache_delete( 'egi_nav_' . $egi_slug, 'egi-optics' );
}

egi_content_log( 'done.' );
