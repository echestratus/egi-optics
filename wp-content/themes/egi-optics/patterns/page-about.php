<?php
/**
 * Title: About page
 * Slug: egi-optics/page-about
 * Categories: egi-optics-pages
 * Description: Complete About page: header, company story, vision and mission, competencies, why EGI, facility and partnership, call to action.
 * Viewport Width: 1400
 * Block Types: core/post-content
 * Post Types: page
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-grid-bg egi-line-bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-grid-bg egi-line-bottom" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","className":"egi-hero__content","layout":{"type":"constrained","justifyContent":"left","contentSize":"860px"}} -->
	<div class="wp-block-group alignwide egi-hero__content">
		<!-- wp:paragraph {"className":"egi-label egi-label--dot"} -->
		<p class="egi-label egi-label--dot"><?php echo esc_html__( 'About EGI Optik Indonesia', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"egi-balance"} -->
		<h1 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Indonesian defense optics, engineered without compromise.', 'egi-optics' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"className":"egi-lead"} -->
		<p class="egi-lead"><?php echo esc_html__( 'PT EGI Optik Indonesia is the defense-optics subsidiary of EGI Resources. Since 2020 we have supplied the Indonesian military with premium laser, thermal and night-vision equipment sourced from leading Eastern European manufacturers such as LEMT - and we are building the local engineering base to design, assemble and sustain those systems at home.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"egi-optics/stats-strip"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:columns {"align":"wide","className":"egi-reveal","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|80"}}}} -->
	<div class="wp-block-columns alignwide egi-reveal">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:paragraph {"className":"egi-label"} -->
			<p class="egi-label"><?php echo esc_html__( 'Our story', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"className":"egi-balance"} -->
			<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'From trusted supplier to national capability.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"width":"60%"} -->
		<div class="wp-block-column" style="flex-basis:60%">
			<!-- wp:paragraph {"className":"egi-lead"} -->
			<p class="egi-lead"><?php echo esc_html__( 'EGI Optik Indonesia was established in 2020 to give Indonesia\'s armed forces direct access to modern optical and electro-optical technology. We began by supplying night-vision goggles, thermal sights and laser aiming devices from Eastern European partners with decades of export experience.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html__( 'Today our portfolio spans directed-energy weapons - a man-portable counter-UAV laser gun and the 10 kW Fenix mobile laser complex - electro-optical surveillance units and the full range of soldier optics. Core technology comes from our partners in Belarus and the wider region; assembly, integration, calibration and after-sales support are performed by EGI engineers in Indonesia. Our mission is to become a giant in the national defense industry by providing customer-focused solutions that meet rigorous quality, productivity and environmental standards.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html__( 'Our systems have been evaluated in live-fire trials with the Army Special Forces Command (Kopassus) and demonstrated to the Presidential Security Force (Paspampres), where operators explored every operating mode and validated the firing procedures, output and time-on-target.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"egi-optics/vision-mission"} /-->
<!-- wp:pattern {"slug":"egi-optics/competencies"} /-->

<!-- wp:group {"align":"full","className":"egi-line-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-line-top" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"720px"}} -->
	<div class="wp-block-group alignwide egi-reveal" style="margin-bottom:var(--wp--preset--spacing--60)">
		<!-- wp:paragraph {"className":"egi-label"} -->
		<p class="egi-label"><?php echo esc_html__( 'Core strength', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"className":"egi-balance"} -->
		<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Facilities, people and service that keep systems mission-ready.', 'egi-optics' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->
	<!-- wp:group {"align":"wide","className":"egi-reveal-stagger","layout":{"type":"grid","minimumColumnWidth":"22rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
	<div class="wp-block-group alignwide egi-reveal-stagger">
		<!-- wp:group {"className":"is-style-egi-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-egi-card">
			<?php echo egi_optics_icon_block( 'building' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|xl"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
			<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--xl)"><?php echo esc_html__( 'Certified clean-room production', 'egi-optics' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|sm"}}} -->
			<p style="font-size:var(--wp--preset--font-size--sm)"><?php echo esc_html__( 'ISO 14644-1 Class 7 clean-room assembly and test facilities in Cikarang, Bekasi, for optics, image intensifier tubes and laser modules.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:group {"className":"is-style-egi-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-egi-card">
			<?php echo egi_optics_icon_block( 'cpu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|xl"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
			<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--xl)"><?php echo esc_html__( 'Qualified engineering team', 'egi-optics' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|sm"}}} -->
			<p style="font-size:var(--wp--preset--font-size--sm)"><?php echo esc_html__( 'Highly qualified engineers and professionals trained by our technology partners, delivering integration on weapons and vehicles, operator courses and detailed standard operating procedures.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<!-- wp:group {"className":"is-style-egi-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group is-style-egi-card">
			<?php echo egi_optics_icon_block( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
			<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"var:preset|font-size|xl"},"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
			<h3 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--40);font-size:var(--wp--preset--font-size--xl)"><?php echo esc_html__( 'After-sales you can rely on', 'egi-optics' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|sm"}}} -->
			<p style="font-size:var(--wp--preset--font-size--sm)"><?php echo esc_html__( '24/7 call-centre support, free calibration and comprehensive training packages for every system we deliver.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"egi-optics/why-egi"} /-->
<!-- wp:pattern {"slug":"egi-optics/cta-contact"} /-->
