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

// Permalinks: posts live under /news/, products under /products/ (CPT rewrite).
global $wp_rewrite;
$wp_rewrite->set_permalink_structure( '/news/%postname%/' );
$wp_rewrite->set_category_base( 'news/category' );
$wp_rewrite->set_tag_base( 'news/tag' );
flush_rewrite_rules( false );
egi_content_log( '  • permalinks: /news/%postname%/' );

egi_content_log( 'done.' );
