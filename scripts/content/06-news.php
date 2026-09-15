<?php
/**
 * 06 - News: "EGI Optik Indonesia demonstrates counter-UAV laser gun to Paspampres" (7 September 2026).
 * Source: internal official report of the visit and demonstration at Mako Paspampres, Tanah Abang.
 *
 * Run: wp eval-file scripts/content/06-news.php   (after 02-media.php)
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

egi_content_log( '== 06 news ==' );

$egi_photo_1 = 'paspampres-demonstration-brig-gen-la-ode-laser-gun.jpg';
$egi_photo_2 = 'paspampres-demonstration-lt-col-deni-sofyan-laser-gun.jpg';
$egi_photo_3 = 'paspampres-demonstration-brig-gen-la-ode-egi-team.jpg';

$egi_product     = get_page_by_path( 'laser-weapon-system', OBJECT, 'egi_product' );
$egi_product_url = $egi_product ? get_permalink( $egi_product ) : home_url( '/products/' );

/**
 * Gallery block from imported photos.
 *
 * @param array $files Array of [basename, caption].
 * @return string
 */
function egi_content_gallery( array $files ) {
	$inner = '';
	$ids   = array();
	foreach ( $files as $f ) {
		$id = egi_content_find_attachment( $f[0] );
		if ( ! $id ) {
			continue;
		}
		$ids[]  = $id;
		$src    = wp_get_attachment_image_url( $id, 'large' );
		$alt    = get_post_meta( $id, '_wp_attachment_image_alt', true );
		$inner .= '<!-- wp:image {"id":' . $id . ',"sizeSlug":"large","linkDestination":"none"} --><figure class="wp-block-image size-large"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" class="wp-image-' . $id . '"/><figcaption class="wp-element-caption">' . egi_b_text( $f[1] ) . '</figcaption></figure><!-- /wp:image -->';
	}
	if ( ! $inner ) {
		return '';
	}
	return '<!-- wp:gallery {"columns":2,"imageCrop":true,"linkTo":"none","sizeSlug":"large","align":"wide"} --><figure class="wp-block-gallery alignwide has-nested-images columns-2 is-cropped">' . $inner . "</figure><!-- /wp:gallery -->\n";
}

$egi_content = ''
	. egi_b_p( '<strong>Jakarta, 7 September 2026</strong> - PT EGI Optik Indonesia has demonstrated its defense and security product line to the Indonesian Presidential Security Force (Paspampres) at the force\'s headquarters, Mako Paspampres in Tanah Abang, Central Jakarta. The session was attended in person by <strong>Brig. Gen. TNI La Ode</strong> and an eleven-strong delegation of officers and specialists, who evaluated the systems hands-on at the Setia Waspada shooting range.' )
	. egi_b_h( 'A live look at the laser weapon system', 2 )
	. egi_b_p( 'With the delegation\'s time limited, the review concentrated first on EGI\'s <a href="' . esc_url( $egi_product_url ) . '">man-portable counter-UAV laser gun</a>. Officers donned protective eyewear, shouldered the weapon and fired it under the guidance of EGI engineers. Brig. Gen. La Ode responded positively to the way the system is fired, the output it produces and the time it takes to achieve an effect on target.' )
	. egi_b_p( 'The laser gun is a non-kinetic system: it dazzles and disrupts the optical sensors of FPV-class drones at ranges of 50 to 500 metres with up to 2 kW of continuous-wave power, drawing its energy from a separate backpack battery pack. It has previously been validated in live-fire trials with the Army Special Forces Command (Kopassus).' )
	. egi_content_gallery(
		array(
			array( $egi_photo_1, 'Brig. Gen. TNI La Ode test-fires the counter-UAV laser gun, wearing Class IV protective eyewear.' ),
			array( $egi_photo_2, 'Lt. Col. Inf. Deni Sofyan walks the delegation through the operating procedure.' ),
		)
	)
	. egi_b_h( 'Hands-on with every operating mode', 2 )
	. egi_b_p( 'Beyond the general\'s review, the entire Paspampres delegation put the products through a thorough evaluation. Each device was tried in detail and every available operating mode was explored. The response was very positive and no additional feature requests were raised. Based on EGI\'s technical briefing, the Paspampres team is compiling its own internal report on the systems demonstrated.' )
	. egi_b_h( 'Feedback that shapes the next iteration', 2 )
	. egi_b_p( 'The most constructive note of the day concerned power supply: the generator used to run the demonstration was judged too noisy for the force\'s operating environment, and the delegation recommended that future configurations rely on quieter, more practical battery power. EGI Optik Indonesia welcomed the recommendation, which will inform the development of the system\'s power supply.' )
	. egi_b_h( 'Standard operating procedures, down to the last detail', 2 )
	. egi_b_p( '<strong>Lt. Col. Inf. Deni Sofyan</strong> gave detailed instructions and guidance on how the equipment should be operated and taught. Every device, he stressed, must be accompanied by a standard operating procedure that specifies each function and step - from opening the goggle case and putting on protective eyewear, to opening the laser transport case, removing the emitter\'s safety cover, and finally aiming and executing a shot with the training unit.' )
	. egi_b_p( 'The briefing also covered the specifications of each system, how the devices interconnect, and the effective operating range of every unit. EGI was transparent about the technology chain: the core laser technology originates from Belarus, while the complete assembly is carried out in Indonesia by EGI engineers.' )
	. egi_content_gallery(
		array(
			array( $egi_photo_3, 'Brig. Gen. TNI La Ode in discussion with the EGI Optik Indonesia team after the demonstration.' ),
		)
	)
	. egi_b_h( 'About the demonstration', 2 )
	. egi_b_list(
		array(
			'<strong>Date:</strong> Monday, 7 September 2026',
			'<strong>Location:</strong> Mako Paspampres, Tanah Abang, Jakarta',
			'<strong>Paspampres delegation:</strong> Brig. Gen. TNI La Ode, Lt. Col. Inf. Deni Sofyan and nine officers and NCOs',
			'<strong>EGI Optik Indonesia:</strong> six-member team led by Dharma Setiawan',
			'<strong>Systems:</strong> man-portable counter-UAV laser weapon system and the wider EGI product line',
		),
		'egi-check'
	)
	. egi_b_p( 'PT EGI Optik Indonesia, the defense-optics subsidiary of EGI Resources, supplies laser weapon systems, counter-UAV complexes, electro-optical surveillance units, thermal sights and night-vision equipment to the Indonesian armed forces and security agencies. Systems are engineered with partners in Eastern Europe and assembled, calibrated and supported in Indonesia. To arrange a demonstration, <a href="' . esc_url( home_url( '/contact/' ) ) . '">contact our team</a>.' );

$egi_post_id = egi_content_upsert_post(
	array(
		'post_type'     => 'post',
		'post_name'     => 'egi-optik-indonesia-demonstrates-counter-uav-laser-gun-to-paspampres',
		'post_title'    => 'EGI Optik Indonesia Demonstrates Counter-UAV Laser Gun to Paspampres',
		'post_excerpt'  => 'The Presidential Security Force evaluated EGI\'s man-portable laser weapon system at its Tanah Abang headquarters on 7 September 2026: live firing led by Brig. Gen. TNI La Ode, a walk-through of every operating mode and constructive feedback for the next iteration.',
		'post_content'  => $egi_content,
		'post_date'     => '2026-09-07 16:00:00',
		'post_date_gmt' => '2026-09-07 09:00:00',
		'post_status'   => 'publish',
	)
);

wp_set_post_categories( $egi_post_id, array( egi_content_ensure_term( 'News', 'category', 'news' ) ) );
wp_set_post_tags( $egi_post_id, array( 'Paspampres', 'Laser Weapon System', 'Demonstration', 'Counter-UAV' ) );

$egi_thumb = egi_content_find_attachment( $egi_photo_1 );
if ( $egi_thumb ) {
	set_post_thumbnail( $egi_post_id, $egi_thumb );
}

egi_content_log( 'done.' );
