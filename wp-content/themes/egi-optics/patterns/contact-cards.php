<?php
/**
 * Title: Contact cards
 * Slug: egi-optics/contact-cards
 * Categories: egi-optics
 * Description: Three cards with address, e-mail and phone numbers bound to the site info.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"align":"wide","className":"egi-reveal-stagger","layout":{"type":"grid","minimumColumnWidth":"18rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-group alignwide egi-reveal-stagger">
	<!-- wp:group {"className":"egi-contact-card","layout":{"type":"constrained"}} -->
	<div class="wp-block-group egi-contact-card">
		<?php echo egi_optics_icon_block( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
		<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Head office', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-text-white","metadata":{"bindings":{"content":{"source":"egi/site","args":{"key":"address"}}}}} -->
		<p class="egi-text-white">Oscorp Building, Jl. Dharmawangsa Raya No. 16, Kebayoran Baru, South Jakarta 12160, Indonesia</p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Production facility', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-text-white","metadata":{"bindings":{"content":{"source":"egi/site","args":{"key":"facility"}}}}} -->
		<p class="egi-text-white">ISO 14644-1 Class 7 clean-room facility, Cikarang, Bekasi</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"egi-contact-card","layout":{"type":"constrained"}} -->
	<div class="wp-block-group egi-contact-card">
		<?php echo egi_optics_icon_block( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
		<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'E-mail', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-text-white"} -->
		<p class="egi-text-white"><a href="mailto:support@egi-optics.com">support@egi-optics.com</a></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Response time', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-text-white"} -->
		<p class="egi-text-white"><?php echo esc_html__( 'Within one business day - 24/7 for supported systems', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"egi-contact-card","layout":{"type":"constrained"}} -->
	<div class="wp-block-group egi-contact-card">
		<?php echo egi_optics_icon_block( 'phone' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
		<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Office', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-text-white"} -->
		<p class="egi-text-white"><a href="tel:+622130629515">+62 21 3062 9515</a></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-label"} --><p class="egi-label"><?php echo esc_html__( 'Mobile / WhatsApp', 'egi-optics' ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-text-white"} -->
		<p class="egi-text-white"><a href="https://wa.me/6287887707139">+62 878-8770-7139</a></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
