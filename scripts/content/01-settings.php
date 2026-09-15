<?php
/**
 * 01 - Site settings: identity, reading, permalinks, company facts.
 *
 * Run: wp eval-file scripts/content/01-settings.php
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

egi_content_log( '== 01 settings ==' );

update_option( 'blogname', 'EGI Optik Indonesia' );
update_option( 'blogdescription', 'Precision Laser and Electro-Optical Defense Systems' );
update_option( 'timezone_string', 'Asia/Jakarta' );
update_option( 'date_format', 'j F Y' );
update_option( 'time_format', 'H:i' );
update_option( 'start_of_week', 1 );
update_option( 'blog_public', 1 );

// Comments off everywhere (the plugin also disables them at runtime).
update_option( 'default_comment_status', 'closed' );
update_option( 'default_ping_status', 'closed' );
update_option( 'comments_notify', 0 );

// Media: keep uploads organised; large image threshold default (2560) is fine.
update_option( 'uploads_use_yearmonth_folders', 1 );

// Production must serve HTTPS URLs (the old install still had http://).
if ( 'production' === wp_get_environment_type() ) {
	$home = home_url();
	if ( 0 === strpos( $home, 'http://' ) ) {
		update_option( 'home', str_replace( 'http://', 'https://', $home ) );
		update_option( 'siteurl', str_replace( 'http://', 'https://', get_option( 'siteurl' ) ) );
		egi_content_log( '  • siteurl/home switched to https' );
	}
}

// Company facts used by the egi/site block bindings.
update_option(
	'egi_site_info',
	array(
		'company'       => 'PT EGI Optik Indonesia',
		'short_name'    => 'EGI Optik Indonesia',
		'tagline'       => 'Precision Laser and Electro-Optical Defense Systems',
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
	)
);

// Categories: "News" is the default; the demo "Uncategorized" is renamed away later by cleanup.
$news_cat = egi_content_ensure_term( 'News', 'category', 'news', 'Company news, demonstrations and events.' );
update_option( 'default_category', $news_cat );

// Product categories.
egi_content_ensure_term( 'Laser Systems', 'product_category', 'laser-systems', 'Directed-energy weapons and counter-UAV laser complexes.' );
egi_content_ensure_term( 'Electro-Optics', 'product_category', 'electro-optics', 'Surveillance and observation units with day, low-light and thermal channels.' );
egi_content_ensure_term( 'Weapon Sights & Aiming', 'product_category', 'weapon-sights-aiming', 'Thermal sights and laser aiming devices for small arms.' );
egi_content_ensure_term( 'Night Vision', 'product_category', 'night-vision', 'Image-intensifier monoculars, goggles and fusion devices.' );

// Rank Math sitemap: include products and product categories, exclude form and attachment post types.
$egi_sitemap = get_option( 'rank-math-options-sitemap', array() );
if ( is_array( $egi_sitemap ) ) {
	$egi_sitemap['pt_egi_product_sitemap']       = 'on';
	$egi_sitemap['tax_product_category_sitemap'] = 'on';
	$egi_sitemap['pt_sureforms_form_sitemap']    = 'off';
	$egi_sitemap['pt_attachment_sitemap']        = 'off';
	$egi_sitemap['tax_post_tag_sitemap']         = 'off';
	update_option( 'rank-math-options-sitemap', $egi_sitemap );
	delete_transient( 'rank_math_sitemap_cache' );
	egi_content_log( '  • Rank Math sitemap: products on, forms off' );
}

// Rank Math titles: products and product categories are indexable with sensible defaults.
$egi_titles = get_option( 'rank-math-options-titles', array() );
if ( is_array( $egi_titles ) ) {
	$egi_titles['pt_egi_product_title']             = '%title% %sep% %sitename%';
	$egi_titles['pt_egi_product_description']       = '%excerpt%';
	$egi_titles['pt_egi_product_robots']            = array( 'index' );
	$egi_titles['pt_egi_product_custom_robots']     = 'off';
	$egi_titles['pt_egi_product_archive_title']     = 'Products %sep% %sitename%';
	$egi_titles['pt_sureforms_form_robots']         = array( 'noindex' );
	$egi_titles['pt_sureforms_form_custom_robots']  = 'on';
	$egi_titles['tax_product_category_title']       = '%term% %sep% Products %sep% %sitename%';
	$egi_titles['tax_product_category_robots']      = array( 'index' );
	$egi_titles['homepage_title']                   = '%sitename% %sep% %sitedesc%';
	$egi_titles['homepage_description']             = 'EGI Optik Indonesia designs, assembles and supports laser weapon systems, counter-UAV complexes, electro-optical surveillance, thermal and night-vision equipment for Indonesia\'s defense and security forces.';
	$egi_titles['title_separator']                  = '·';
	update_option( 'rank-math-options-titles', $egi_titles );
	egi_content_log( '  • Rank Math titles: product defaults set, forms noindex' );
}

// LiteSpeed Cache: Guest Mode requests /wp-content/plugins/litespeed-cache/guest.vary.php, which Solid
// Security's "disable PHP in plugins" rule blocks with a 403 (visible as a JS error on every page). The
// page cache itself does not depend on Guest Mode, so keep it off.
if ( false !== get_option( 'litespeed.conf.guest', false ) ) {
	update_option( 'litespeed.conf.guest', false );
	update_option( 'litespeed.conf.guest_optm', false );
	egi_content_log( '  • LiteSpeed Guest Mode disabled (conflicts with Solid Security PHP-in-plugins rule)' );
}

// Permalinks: posts live under /news/, products under /products/ (CPT rewrite).
global $wp_rewrite;
$wp_rewrite->set_permalink_structure( '/news/%postname%/' );
$wp_rewrite->set_category_base( 'news/category' );
$wp_rewrite->set_tag_base( 'news/tag' );
flush_rewrite_rules( false );
egi_content_log( '  • permalinks: /news/%postname%/' );

egi_content_log( 'done.' );
