<?php
/**
 * Title: Stats strip
 * Slug: egi-optics/stats-strip
 * Categories: egi-optics
 * Description: Four key figures in a bordered strip, dividing lines between columns.
 * Viewport Width: 1400
 *
 * @package EGI_Optics
 */

$egi_optics_stats = array(
	array( '2020', __( 'Established in Jakarta', 'egi-optics' ) ),
	array( '7', __( 'Defense systems in catalogue', 'egi-optics' ) ),
	array( '10 kW', __( 'Directed-energy output (Fenix)', 'egi-optics' ) ),
	array( '24/7', __( 'In-country technical support', 'egi-optics' ) ),
);
?>
<!-- wp:group {"align":"full","className":"egi-stats-strip egi-reveal","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-stats-strip egi-reveal">
	<!-- wp:columns {"align":"wide","className":"egi-cols-mobile-2","style":{"spacing":{"blockGap":{"top":"0","left":"0"}}}} -->
	<div class="wp-block-columns alignwide egi-cols-mobile-2">
		<?php foreach ( $egi_optics_stats as $egi_optics_stat ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"egi-stat","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-stat">
				<!-- wp:paragraph {"className":"egi-stat__value"} -->
				<p class="egi-stat__value"><?php echo esc_html( $egi_optics_stat[0] ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph {"className":"egi-stat__label"} -->
				<p class="egi-stat__label"><?php echo esc_html( $egi_optics_stat[1] ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
