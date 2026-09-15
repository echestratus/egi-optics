<?php
/**
 * Title: Product body (default structure)
 * Slug: egi-optics/product-body
 * Categories: egi-optics
 * Description: Default sections for a product: overview, key benefits and applications, key figures, specification groups, safety, field trial video. Used as the template for new products.
 * Viewport Width: 1400
 * Block Types: core/post-content
 * Post Types: egi_product
 *
 * @package EGI_Optics
 */

?>
<!-- wp:group {"className":"egi-product-section","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group egi-product-section" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|70","top":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"58%"} -->
		<div class="wp-block-column" style="flex-basis:58%">
			<!-- wp:paragraph {"className":"egi-label"} -->
			<p class="egi-label"><?php echo esc_html__( 'Overview', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"style":{"typography":{"fontSize":"var:preset|font-size|3xl"}}} -->
			<h2 class="wp-block-heading" style="font-size:var(--wp--preset--font-size--3xl)"><?php echo esc_html__( 'What the system does and who it is for.', 'egi-optics' ); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"egi-lead"} -->
			<p class="egi-lead"><?php echo esc_html__( 'Two or three sentences describing the platform, its core capability and the operational problem it solves.', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:paragraph {"className":"egi-label egi-label--muted"} -->
			<p class="egi-label egi-label--muted"><?php echo esc_html__( 'Key benefits', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"is-style-egi-square"} -->
			<ul class="wp-block-list is-style-egi-square">
				<!-- wp:list-item --><li><?php echo esc_html__( 'Benefit one - the headline capability', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( 'Benefit two - range, power or resolution figure', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( 'Benefit three - deployment or integration advantage', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( 'Benefit four - safety, endurance or logistics', 'egi-optics' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
			<!-- wp:paragraph {"className":"egi-label egi-label--muted","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<p class="egi-label egi-label--muted" style="margin-top:var(--wp--preset--spacing--50)"><?php echo esc_html__( 'Applications', 'egi-optics' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"is-style-egi-tags"} -->
			<ul class="wp-block-list is-style-egi-tags">
				<!-- wp:list-item --><li><?php echo esc_html__( 'Counter-UAS operations', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( 'Critical infrastructure protection', 'egi-optics' ); ?></li><!-- /wp:list-item -->
				<!-- wp:list-item --><li><?php echo esc_html__( 'Forward operating bases', 'egi-optics' ); ?></li><!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"egi-cols-mobile-2 egi-reveal-stagger","style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"grid","minimumColumnWidth":"11rem"}} -->
<div class="wp-block-group alignwide egi-cols-mobile-2 egi-reveal-stagger" style="margin-top:var(--wp--preset--spacing--50)">
	<?php
	$egi_optics_stats = array(
		array( '2 kW', __( 'Output power', 'egi-optics' ) ),
		array( '500 m', __( 'Effective range', 'egi-optics' ) ),
		array( '< 10 s', __( 'Time to effect', 'egi-optics' ) ),
		array( '4.5 kg', __( 'Weight', 'egi-optics' ) ),
	);
	foreach ( $egi_optics_stats as $egi_optics_stat ) :
		?>
	<!-- wp:group {"className":"egi-stat","layout":{"type":"constrained"}} -->
	<div class="wp-block-group egi-stat">
		<!-- wp:paragraph {"className":"egi-stat__value"} --><p class="egi-stat__value"><?php echo esc_html( $egi_optics_stat[0] ); ?></p><!-- /wp:paragraph -->
		<!-- wp:paragraph {"className":"egi-stat__label"} --><p class="egi-stat__label"><?php echo esc_html( $egi_optics_stat[1] ); ?></p><!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
	<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide egi-reveal" style="margin-top:var(--wp--preset--spacing--70)">
	<!-- wp:paragraph {"className":"egi-label"} -->
	<p class="egi-label"><?php echo esc_html__( 'Technical specifications', 'egi-optics' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40","top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"egi-spec-group","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-spec-group">
				<!-- wp:heading {"level":3} --><h3 class="wp-block-heading"><?php echo esc_html__( 'Laser', 'egi-optics' ); ?></h3><!-- /wp:heading -->
				<!-- wp:table {"className":"is-style-egi-spec"} -->
				<figure class="wp-block-table is-style-egi-spec"><table><tbody>
					<tr><td><?php echo esc_html__( 'Wavelength', 'egi-optics' ); ?></td><td>1080 nm</td></tr>
					<tr><td><?php echo esc_html__( 'Output power', 'egi-optics' ); ?></td><td>0.75 â€“ 2.0 kW CW</td></tr>
					<tr><td><?php echo esc_html__( 'Effective range', 'egi-optics' ); ?></td><td>30 â€“ 500 m</td></tr>
				</tbody></table></figure>
				<!-- /wp:table -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"egi-spec-group","layout":{"type":"constrained"}} -->
			<div class="wp-block-group egi-spec-group">
				<!-- wp:heading {"level":3} --><h3 class="wp-block-heading"><?php echo esc_html__( 'System', 'egi-optics' ); ?></h3><!-- /wp:heading -->
				<!-- wp:table {"className":"is-style-egi-spec"} -->
				<figure class="wp-block-table is-style-egi-spec"><table><tbody>
					<tr><td><?php echo esc_html__( 'Power supply', 'egi-optics' ); ?></td><td>Backpack, 7.5 kW</td></tr>
					<tr><td><?php echo esc_html__( 'Cooling', 'egi-optics' ); ?></td><td>Air-cooled</td></tr>
					<tr><td><?php echo esc_html__( 'Operating temperature', 'egi-optics' ); ?></td><td>-20 Â°C â€¦ +50 Â°C</td></tr>
				</tbody></table></figure>
				<!-- /wp:table -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"is-style-egi-panel egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide is-style-egi-panel egi-reveal" style="margin-top:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"className":"egi-label"} -->
	<p class="egi-label"><?php echo esc_html__( 'Integrated safety', 'egi-optics' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:list {"className":"is-style-egi-check","style":{"typography":{"fontSize":"var:preset|font-size|sm"}}} -->
	<ul class="wp-block-list is-style-egi-check" style="font-size:var(--wp--preset--font-size--sm)">
		<!-- wp:list-item --><li><?php echo esc_html__( 'Emission lock key prevents unauthorised activation', 'egi-optics' ); ?></li><!-- /wp:list-item -->
		<!-- wp:list-item --><li><?php echo esc_html__( 'Emergency stop for instant shutdown', 'egi-optics' ); ?></li><!-- /wp:list-item -->
		<!-- wp:list-item --><li><?php echo esc_html__( 'Class IV laser compliance and protective eyewear supplied', 'egi-optics' ); ?></li><!-- /wp:list-item -->
	</ul>
	<!-- /wp:list -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"egi-optics/field-trial-video"} /-->
