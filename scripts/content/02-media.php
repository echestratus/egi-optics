<?php
/**
 * 02 - Media: import prepared assets with alt text, set logo and site icon.
 *
 * Run: EGI_ASSETS_DIR=/path/to/assets wp eval-file scripts/content/02-media.php
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';

egi_content_log( '== 02 media ==' );
egi_content_log( '  assets dir: ' . ( egi_content_assets_dir() ? egi_content_assets_dir() : '(none found!)' ) );

$egi_media = array(
	// Brand.
	'logo-egi-optik-indonesia-light.png'                => array(
		'title' => 'EGI Optik Indonesia logo (light)',
		'alt'   => 'EGI Optik Indonesia logo',
	),
	'logo-egi-optik-indonesia.png'                      => array(
		'title' => 'EGI Optik Indonesia logo',
		'alt'   => 'EGI Optik Indonesia logo',
	),
	'site-icon-egi-optik.png'                           => array(
		'title' => 'EGI Optik Indonesia site icon',
		'alt'   => '',
	),

	// Laser Weapon System (man-portable counter-UAV laser gun).
	'laser-weapon-system-counter-uav-laser-gun.png'     => array(
		'title' => 'Laser Weapon System - counter-UAV laser gun',
		'alt'   => 'EGI Laser Weapon System: man-portable counter-UAV laser gun with optical sight and backpack power cable',
	),
	'laser-weapon-system-laser-gun-side.png'            => array(
		'title' => 'Laser Weapon System - side view',
		'alt'   => 'Side view of the man-portable counter-UAV laser gun showing the emitter aperture and grip',
	),
	'laser-weapon-system-fpv-camera-disruption.png'     => array(
		'title' => 'FPV drone camera disruption',
		'alt'   => 'Split screen from a laser test: FPV drone camera view before and during laser dazzling at close range',
	),
	'laser-weapon-system-render.png'                    => array(
		'title' => 'Laser Weapon System render',
		'alt'   => 'Rendering of the EGI laser weapon system rifle-style platform',
	),

	// Fenix mobile counter-UAV laser complex.
	'fenix-counter-uav-laser-complex-turret.png'        => array(
		'title' => 'Fenix laser complex - turret',
		'alt'   => 'Fenix counter-UAV laser complex electro-optical turret mounted on a vehicle roof',
	),
	'fenix-counter-uav-laser-complex-maz-chassis.png'   => array(
		'title' => 'Fenix laser complex on MAZ chassis',
		'alt'   => 'Fenix mobile counter-UAV laser complex container and turret mounted on a MAZ 6x6 truck chassis',
	),
	'fenix-counter-uav-laser-complex-overview.png'      => array(
		'title' => 'Fenix laser complex - system overview',
		'alt'   => 'Overview collage of the Fenix laser complex: truck-mounted container, turret and operator console',
	),
	'fenix-counter-uav-laser-complex-container.png'     => array(
		'title' => 'Fenix laser complex - container module',
		'alt'   => 'Rendering of the Fenix laser complex container module with roof-mounted turret',
	),

	// Remote Control Observation Unit.
	'remote-control-observation-unit-anoa-apc.webp'     => array(
		'title' => 'Remote Control Observation Unit on Pindad Anoa',
		'alt'   => 'Remote Control Observation Unit integrated on a Pindad Anoa 6x6 armoured personnel carrier',
	),
	'remote-control-observation-unit.png'               => array(
		'title' => 'Remote Control Observation Unit',
		'alt'   => 'Remote Control Observation Unit electro-optical sensor head',
	),

	// Laser Point LAD-21T.
	'laser-point-lad-21t.png'                           => array(
		'title' => 'Laser Point LAD-21T',
		'alt'   => 'LAD-21T multipurpose laser aiming device with visible red and infrared channels',
	),
	'laser-point-lad-21t-side.png'                      => array(
		'title' => 'Laser Point LAD-21T - controls',
		'alt'   => 'LAD-21T laser aiming device showing the mode selector and Picatinny mount',
	),

	// Thermal Vision Sight TVD-35.
	'thermal-vision-sight-tvd-35.png'                   => array(
		'title' => 'Thermal Vision Sight TVD-35',
		'alt'   => 'TVD-35 uncooled thermal weapon sight, side view',
	),
	'thermal-vision-sight-tvd-35-front.png'             => array(
		'title' => 'Thermal Vision Sight TVD-35 - front',
		'alt'   => 'TVD-35 thermal weapon sight objective lens, front view',
	),
	'thermal-vision-sight-tvd-35-side.png'              => array(
		'title' => 'Thermal Vision Sight TVD-35 - profile',
		'alt'   => 'TVD-35 thermal weapon sight with eyepiece and Picatinny mount, profile view',
	),

	// Night vision.
	'night-vision-monocular-nv-m-19-helmet.png'         => array(
		'title' => 'NV/M-19 night vision monocular on helmet',
		'alt'   => 'Soldier wearing the NV/M-19 Gen 4 night vision monocular on a helmet mount',
	),
	'night-vision-goggles-nv-g-14.png'                  => array(
		'title' => 'NV/G-14 night vision goggles',
		'alt'   => 'NV/G-14 binocular night vision goggles with flat compact design',
	),
	'night-vision-monocular-nv-m-19.png'                => array(
		'title' => 'NV/M-19 night vision monocular',
		'alt'   => 'NV/M-19 Gen 4 image-intensifier night vision monocular',
	),
	'night-vision-monocular-nv-m-19-rifle.png'          => array(
		'title' => 'NV/M-19 mounted on rifle',
		'alt'   => 'NV/M-19 night vision monocular mounted on a service rifle behind a collimator sight',
	),

	// Fusion TN-KS/2.
	'fusion-tn-ks-2.png'                                => array(
		'title' => 'Fusion TN-KS/2',
		'alt'   => 'TN-KS/2 fusion night vision and thermal observation device, tan version',
	),
	'fusion-tn-ks-2-black.png'                          => array(
		'title' => 'Fusion TN-KS/2 - black',
		'alt'   => 'TN-KS/2 fusion observation device, black version',
	),
	'fusion-tn-ks-2-helmet-mount.png'                   => array(
		'title' => 'Fusion TN-KS/2 helmet mount',
		'alt'   => 'Helmet mount for the TN-KS/2 fusion device',
	),
	'fusion-tn-ks-2-channels-diagram.png'               => array(
		'title' => 'Fusion TN-KS/2 channels',
		'alt'   => 'Diagram of the TN-KS/2 night vision channel, thermal channel and fused image on a helmet',
	),

	// Videos and posters.
	'laser-weapon-system-kopassus-live-fire-trial.mp4'  => array( 'title' => 'Laser Weapon System - live-fire trial with Kopassus' ),
	'laser-weapon-system-kopassus-live-fire-trial-poster.jpg' => array(
		'title' => 'Kopassus live-fire trial (poster)',
		'alt'   => 'Still frame from the Kopassus live-fire trial of the laser weapon system',
	),
	'laser-gun-laboratory-material-test.mp4'            => array( 'title' => 'Laser gun - laboratory material test' ),
	'laser-gun-laboratory-material-test-poster.jpg'     => array(
		'title' => 'Laser gun laboratory test (poster)',
		'alt'   => 'Still frame from the laser gun laboratory material penetration test',
	),
	'fiber-laser-rnd-laboratory.mp4'                    => array( 'title' => 'Fiber laser R&D laboratory' ),
	'fiber-laser-rnd-laboratory-poster.jpg'             => array(
		'title' => 'Fiber laser laboratory (poster)',
		'alt'   => 'Still frame from the EGI fiber laser research and development laboratory',
	),
	'nvg-clean-room-to-dark-room-transition.mp4'        => array( 'title' => 'NVG clean room to dark room transition' ),
	'nvg-clean-room-to-dark-room-transition-poster.jpg' => array(
		'title' => 'NVG transition test (poster)',
		'alt'   => 'Still frame from the night vision goggle clean-room to dark-room transition test',
	),

	// Datasheets.
	'EGI-Night-Vision-Monocular-NV-M-19-Gen4-Datasheet.pdf' => array( 'title' => 'Datasheet - Night Vision Monocular NV/M-19 Gen 4' ),
	'EGI-Thermal-Vision-Sight-TVD-35-Datasheet.pdf'     => array( 'title' => 'Datasheet - Thermal Vision Sight TVD-35' ),
	'EGI-Laser-Point-LAD-21T-Datasheet.pdf'             => array( 'title' => 'Datasheet - Laser Point LAD-21T' ),
	'EGI-Laser-Weapon-System-Fenix-Complex-Remote-Control-Unit-Datasheet.pdf' => array( 'title' => 'Datasheet - Laser Weapon System, Fenix Complex and Remote Control Unit' ),

	// News photos (Paspampres demonstration, 7 September 2026).
	'paspampres-demonstration-brig-gen-la-ode-laser-gun.jpg' => array(
		'title'   => 'Brig. Gen. TNI La Ode test-fires the EGI laser gun',
		'alt'     => 'Brigadier General TNI La Ode wearing protective laser goggles aims the EGI counter-UAV laser gun at the Setia Waspada Shooting Club, Mako Paspampres, while an EGI engineer observes',
		'caption' => 'Brig. Gen. TNI La Ode test-fires the EGI counter-UAV laser gun at Mako Paspampres, Tanah Abang, 7 September 2026.',
	),
	'paspampres-demonstration-brig-gen-la-ode-egi-team.jpg' => array(
		'title'   => 'Brig. Gen. TNI La Ode in discussion with the EGI team',
		'alt'     => 'Brigadier General TNI La Ode in discussion with EGI Optik Indonesia representatives at the Paspampres shooting range',
		'caption' => 'Brig. Gen. TNI La Ode discusses the laser system with the EGI Optik Indonesia team after the live demonstration.',
	),
	'paspampres-demonstration-lt-col-deni-sofyan-laser-gun.jpg' => array(
		'title'   => 'Lt. Col. Inf. Deni Sofyan handles the laser gun',
		'alt'     => 'Lieutenant Colonel Infantry Deni Sofyan wearing protective goggles shoulders the EGI counter-UAV laser gun, with a Paspampres officer and an EGI engineer beside him',
		'caption' => 'Lt. Col. Inf. Deni Sofyan walks the delegation through the operating procedure of the laser gun.',
	),
);

$egi_imported = 0;
foreach ( $egi_media as $egi_file => $egi_args ) {
	if ( egi_content_import_media( $egi_file, $egi_args ) ) {
		++$egi_imported;
	}
}
egi_content_log( "  {$egi_imported}/" . count( $egi_media ) . ' assets available in the Media Library.' );

// Logo (light variant reads well on the dark theme) and site icon.
$egi_logo = egi_content_find_attachment( 'logo-egi-optik-indonesia-light.png' );
if ( $egi_logo ) {
	set_theme_mod( 'custom_logo', $egi_logo );
	egi_content_log( "  • custom_logo = #{$egi_logo}" );
}
$egi_icon = egi_content_find_attachment( 'site-icon-egi-optik.png' );
if ( $egi_icon ) {
	update_option( 'site_icon', $egi_icon );
	egi_content_log( "  • site_icon = #{$egi_icon}" );
}

egi_content_log( 'done.' );
