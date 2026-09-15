<?php
/**
 * 04 - Pages: Home, About, Contact, News (posts index). Content is expanded from theme patterns so
 * editors get fully editable blocks; datasheet links and the contact form are injected.
 *
 * Run: wp eval-file scripts/content/04-pages.php   (after 02-media.php and 03-products.php)
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

egi_content_log( '== 04 pages ==' );

/**
 * Replace the placeholder download rows in the Downloads pattern with real Media Library links.
 *
 * @param string $content Expanded page markup.
 * @return string
 */
function egi_content_fill_downloads( $content ) {
	$docs = array(
		'Night Vision Monocular NV/M-19 Gen 4' => 'EGI-Night-Vision-Monocular-NV-M-19-Gen4-Datasheet.pdf',
		'Thermal Vision Sight TVD-35'          => 'EGI-Thermal-Vision-Sight-TVD-35-Datasheet.pdf',
		'Laser Point LAD-21T'                  => 'EGI-Laser-Point-LAD-21T-Datasheet.pdf',
		'Laser Weapon System, Fenix Counter-UAV Complex and Remote Control Unit' => 'EGI-Laser-Weapon-System-Fenix-Complex-Remote-Control-Unit-Datasheet.pdf',
	);
	foreach ( $docs as $label => $file ) {
		$id = egi_content_find_attachment( $file );
		if ( ! $id ) {
			continue;
		}
		$url  = wp_get_attachment_url( $id );
		$size = egi_content_media_size( $file );
		// The pattern renders: <!-- wp:file {"displayPreview":false,"showDownloadButton":true} --><div class="wp-block-file"><a href="#">LABEL</a><a href="#" class="wp-block-file__button ...
		$search  = '<div class="wp-block-file"><a href="#">' . $label . '</a><a href="#"';
		$replace = '<div class="wp-block-file"><a id="wp-block-file--media-' . $id . '" href="' . esc_url( $url ) . '">' . $label . '</a><a href="' . esc_url( $url ) . '"';
		$content = str_replace( $search, $replace, $content );
		$content = str_replace( '<!-- wp:file {"displayPreview":false,"showDownloadButton":true} --><div class="wp-block-file"><a id="wp-block-file--media-' . $id . '"', '<!-- wp:file {"id":' . $id . ',"href":"' . esc_url( $url ) . '","displayPreview":false,"showDownloadButton":true} --><div class="wp-block-file"><a id="wp-block-file--media-' . $id . '"', $content );
		// Size label after the file.
		$content = preg_replace( '/(' . preg_quote( $label, '/' ) . '<\/a>.*?<\/div><!-- \/wp:file -->\s*<!-- wp:paragraph \{"className":"egi-download__meta"\} --><p class="egi-download__meta">)[^<]*/s', '${1}PDF · ' . $size, $content, 1 );
	}
	return $content;
}

/**
 * Insert the SureForms contact form (first published form) in place of the placeholder paragraph.
 *
 * @param string $content Expanded page markup.
 * @return string
 */
function egi_content_fill_contact_form( $content ) {
	$forms = get_posts(
		array(
			'post_type'   => 'sureforms_form',
			'post_status' => 'publish',
			'numberposts' => 1,
			'orderby'     => 'ID',
			'order'       => 'DESC',
			'fields'      => 'ids',
		)
	);
	if ( ! $forms ) {
		egi_content_log( '  ! no SureForms form found - placeholder kept' );
		return $content;
	}
	$form_id = (int) $forms[0];
	$block   = '<!-- wp:srfm/form {"id":' . $form_id . '} /-->';
	$content = preg_replace( '/<!-- wp:paragraph \{"className":"egi-form-placeholder"\} -->.*?<!-- \/wp:paragraph -->/s', $block, $content, 1 );
	egi_content_log( "  • contact form #{$form_id} inserted" );
	return $content;
}

// Home.
$egi_home_content = egi_content_fill_downloads( egi_content_expand_patterns( '<!-- wp:pattern {"slug":"egi-optics/page-home"} /-->' ) );
$egi_home         = egi_content_upsert_post(
	array(
		'post_type'    => 'page',
		'post_name'    => 'home',
		'post_title'   => 'Home',
		'post_content' => $egi_home_content,
		'post_excerpt' => 'EGI Optik Indonesia designs, assembles and supports laser weapon systems, counter-UAV complexes, electro-optical surveillance, thermal and night-vision equipment for Indonesia\'s defense and security forces.',
	),
	array(
		'_wp_page_template'     => 'page-landing',
		// Rank Math uses the page title for a static front page; give the home page a brand title instead.
		'rank_math_title'       => '%sitename% %sep% %sitedesc%',
		'rank_math_description' => 'EGI Optik Indonesia designs, assembles and supports laser weapon systems, counter-UAV complexes, electro-optical surveillance, thermal and night-vision equipment for Indonesia\'s defense and security forces.',
	)
);

// About.
$egi_about = egi_content_upsert_post(
	array(
		'post_type'    => 'page',
		'post_name'    => 'about',
		'post_title'   => 'About',
		'post_content' => egi_content_expand_patterns( '<!-- wp:pattern {"slug":"egi-optics/page-about"} /-->' ),
		'post_excerpt' => 'PT EGI Optik Indonesia, the defense-optics subsidiary of EGI Resources: story, vision and mission, core competencies, facilities and partnerships.',
	),
	array( '_wp_page_template' => 'page-landing' )
);

// Contact.
$egi_contact = egi_content_upsert_post(
	array(
		'post_type'    => 'page',
		'post_name'    => 'contact',
		'post_title'   => 'Contact',
		'post_content' => egi_content_fill_contact_form( egi_content_expand_patterns( '<!-- wp:pattern {"slug":"egi-optics/page-contact"} /-->' ) ),
		'post_excerpt' => 'Request a demonstration or technical briefing. EGI Optik Indonesia, Oscorp Building, Jl. Dharmawangsa Raya No. 16, South Jakarta.',
	),
	array( '_wp_page_template' => 'page-landing' )
);

// News index page (was "Blog"). Rename if the old page exists, otherwise create.
$egi_blog = get_page_by_path( 'blog', OBJECT, 'page' );
if ( $egi_blog ) {
	$egi_renamed = wp_update_post(
		array(
			'ID'            => $egi_blog->ID,
			'post_title'    => 'News',
			'post_name'     => 'news',
			'post_content'  => '',
			'page_template' => 'default', // the old Solace template no longer exists.
		),
		true
	);
	if ( is_wp_error( $egi_renamed ) ) {
		WP_CLI::error( 'Failed to rename Blog page: ' . $egi_renamed->get_error_message() );
	}
	$egi_news = (int) $egi_blog->ID;
	egi_content_log( "  • page #{$egi_news} renamed Blog -> News" );
} else {
	$egi_news = egi_content_upsert_post(
		array(
			'post_type'    => 'page',
			'post_name'    => 'news',
			'post_title'   => 'News',
			'post_content' => '',
			'post_excerpt' => 'News, demonstrations, field trials and product milestones from EGI Optik Indonesia.',
		)
	);
}

// Reading settings.
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $egi_home );
update_option( 'page_for_posts', $egi_news );
update_option( 'posts_per_page', 9 );
egi_content_log( "  • front page #{$egi_home}, posts page #{$egi_news}" );

// Privacy policy page (WordPress default) gets the narrow template if it exists.
$egi_privacy = (int) get_option( 'wp_page_for_privacy_policy' );
if ( $egi_privacy ) {
	update_post_meta( $egi_privacy, '_wp_page_template', 'page-narrow' );
}

egi_content_log( 'done.' );
