<?php
/**
 * Title: Contact page
 * Slug: egi-optics/page-contact
 * Categories: egi-optics-pages
 * Description: Complete Contact page: header, contact cards, form column with map, closing note.
 * Viewport Width: 1400
 * Block Types: core/post-content
 * Post Types: page
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"full","className":"egi-grid-bg egi-line-bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-grid-bg egi-line-bottom" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:group {"align":"wide","className":"egi-hero__content","layout":{"type":"constrained","justifyContent":"left","contentSize":"820px"}} -->
	<div class="wp-block-group alignwide egi-hero__content">
		<!-- wp:paragraph {"className":"egi-label egi-label--dot"} -->
		<p class="egi-label egi-label--dot"><?php echo esc_html__( 'Contact', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"className":"egi-balance"} -->
		<h1 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Get in touch with EGI Optik Indonesia.', 'egi-optics' ); ?></h1>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"className":"egi-lead"} -->
		<p class="egi-lead"><?php echo esc_html__( 'Request a live demonstration, a technical briefing or support for a system in service. Our team responds within one business day - and around the clock for supported systems.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:pattern {"slug":"egi-optics/contact-cards"} /-->

	<!-- wp:columns {"align":"wide","className":"egi-reveal","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70","top":"var:preset|spacing|60"},"margin":{"top":"var:preset|spacing|70"}}}} -->
	<div class="wp-block-columns alignwide egi-reveal" style="margin-top:var(--wp--preset--spacing--70)">
		<!-- wp:column {"width":"55%"} -->
		<div class="wp-block-column" style="flex-basis:55%">
			<!-- wp:paragraph {"className":"egi-label"} -->
			<p class="egi-label"><?php echo esc_html__( 'Send a message', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"typography":{"fontSize":"var:preset|font-size|3xl"}}} -->
			<h2 class="wp-block-heading" style="font-size:var(--wp--preset--font-size--3xl)"><?php echo esc_html__( 'Tell us about your requirement.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:group {"className":"egi-form-wrap is-style-egi-panel","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-form-wrap is-style-egi-panel">
				<!-- wp:paragraph {"className":"egi-form-placeholder"} -->
				<p class="egi-form-placeholder"><?php echo esc_html__( 'Insert the SureForms contact form block here.', 'egi-optics' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"width":"45%"} -->
		<div class="wp-block-column" style="flex-basis:45%">
			<!-- wp:paragraph {"className":"egi-label"} -->
			<p class="egi-label"><?php echo esc_html__( 'Visit us', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"typography":{"fontSize":"var:preset|font-size|3xl"}}} -->
			<h2 class="wp-block-heading" style="font-size:var(--wp--preset--font-size--3xl)"><?php echo esc_html__( 'Kebayoran Baru, South Jakarta.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:html -->
			<div class="egi-map"><iframe title="<?php echo esc_attr__( 'Map showing the EGI Optik Indonesia office at Oscorp Building, Jl. Dharmawangsa Raya No. 16, Jakarta', 'egi-optics' ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps?q=Oscorp+Building+Jl.+Dharmawangsa+Raya+No.16+Kebayoran+Baru+Jakarta&amp;output=embed"></iframe></div>
			<!-- /wp:html -->
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"var:preset|font-size|sm"}}} -->
			<p style="font-size:var(--wp--preset--font-size--sm)"><?php echo esc_html__( 'Demonstrations for defense and security agencies are arranged at our facilities or at the customer\'s location. Visits to the Cikarang production facility are by appointment.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
