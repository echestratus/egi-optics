<?php
/**
 * 07 - Cleanup of template demo content left by the previous site (reversible: everything is trashed,
 * not deleted). Old Elementor product pages are trashed only when the replacement product exists,
 * so the 301 redirects in egi-optics-core take over.
 *
 * Run: wp eval-file scripts/content/07-cleanup.php   (production only, after 03-06)
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

egi_content_log( '== 07 cleanup ==' );

/**
 * Trash a post by slug/type if it exists.
 *
 * @param string $slug Slug.
 * @param string $type Post type.
 */
function egi_content_trash( $slug, $type ) {
	$post = get_page_by_path( $slug, OBJECT, $type );
	if ( $post && 'trash' !== $post->post_status ) {
		wp_trash_post( $post->ID );
		egi_content_log( "  • trashed {$type} #{$post->ID} /{$slug}/" );
	}
}

// Demo posts ("Strategic consulting" placeholders + Hello world).
foreach ( array(
	'hello-world',
	'driving-success-through-expert-guidance',
	'top-skills-every-strategic-consultant-should-master',
	'why-strategic-consulting-is-the-key-to-sustainable-growth',
	'successful-transformations-led-by-strategic-consultants',
	'how-to-choose-the-right-strategic-consultant-for-your-business',
	'strategic-consulting-for-startups-building-a-solid-foundation',
) as $egi_slug ) {
	egi_content_trash( $egi_slug, 'post' );
}

// Demo pages.
foreach ( array( 'clients', 'career', 'locations' ) as $egi_slug ) {
	egi_content_trash( $egi_slug, 'page' );
}

// Old Elementor product pages, replaced by the Products post type.
$egi_replaced = array(
	'laser-gun'            => 'laser-weapon-system',
	'laser-weapon-system'  => 'fenix-counter-uav-laser-complex',
	'thermal-vision-sight' => 'thermal-vision-sight-tvd-35',
	'night-vision'         => 'night-vision-monocular-nv-m-19',
	'laser-point'          => 'laser-point-lad-21t',
	'fusion'               => 'fusion-tn-ks-2',
);
foreach ( $egi_replaced as $egi_old => $egi_new ) {
	if ( get_page_by_path( $egi_new, OBJECT, 'egi_product' ) ) {
		egi_content_trash( $egi_old, 'page' );
	} else {
		egi_content_log( "  ! product {$egi_new} missing - kept old page /{$egi_old}/" );
	}
}

// Demo classic menus (not used by the block theme).
foreach ( array( 'products', 'company', 'features', 'primary-menu', 'main-menu' ) as $egi_menu ) {
	$egi_term = wp_get_nav_menu_object( $egi_menu );
	if ( $egi_term ) {
		wp_delete_nav_menu( $egi_term->term_id );
		egi_content_log( "  • deleted classic menu '{$egi_menu}'" );
	}
}

// Duplicate SureForms forms: keep the newest published "Simple Contact Form", trash the rest.
$egi_forms = get_posts(
	array(
		'post_type'   => 'sureforms_form',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby'     => 'ID',
		'order'       => 'DESC',
	)
);
foreach ( array_slice( $egi_forms, 1 ) as $egi_form ) {
	wp_trash_post( $egi_form->ID );
	egi_content_log( "  • trashed duplicate form #{$egi_form->ID} {$egi_form->post_title}" );
}
if ( $egi_forms ) {
	wp_update_post(
		array(
			'ID'         => $egi_forms[0]->ID,
			'post_title' => 'Contact form',
		)
	);
}

// Rename the default "Uncategorized" category to keep URLs tidy (posts already moved to News).
$egi_uncat = get_term_by( 'slug', 'uncategorized', 'category' );
if ( $egi_uncat && 0 === (int) $egi_uncat->count ) {
	$egi_news = get_term_by( 'slug', 'news', 'category' );
	if ( $egi_news && (int) get_option( 'default_category' ) === (int) $egi_news->term_id ) {
		wp_delete_term( $egi_uncat->term_id, 'category' );
		egi_content_log( '  • deleted empty Uncategorized category' );
	}
}

// Pages rebuilt with blocks must not be rendered by Elementor if it is ever re-activated:
// drop the "built with Elementor" flag (the old design data stays in the pre-overhaul backup).
foreach ( array( 'home', 'about', 'contact', 'news' ) as $egi_slug ) {
	$egi_page = get_page_by_path( $egi_slug, OBJECT, 'page' );
	if ( $egi_page ) {
		delete_post_meta( $egi_page->ID, '_elementor_edit_mode' );
		delete_post_meta( $egi_page->ID, '_elementor_template_type' );
		delete_post_meta( $egi_page->ID, '_elementor_data' );
		delete_post_meta( $egi_page->ID, '_elementor_css' );
	}
}

// Elementor / Solace leftovers in the library (templates, kits) - trash so they can be restored if needed.
foreach ( array( 'elementor_library', 'solace-sitebuilder', 'ha_library', 'e-floating-buttons' ) as $egi_type ) {
	if ( ! post_type_exists( $egi_type ) ) {
		continue;
	}
	$egi_items = get_posts(
		array(
			'post_type'   => $egi_type,
			'post_status' => 'any',
			'numberposts' => -1,
			'fields'      => 'ids',
		)
	);
	foreach ( $egi_items as $egi_item ) {
		wp_trash_post( $egi_item );
	}
	if ( $egi_items ) {
		egi_content_log( '  • trashed ' . count( $egi_items ) . " {$egi_type} items" );
	}
}

egi_content_log( 'done.' );
