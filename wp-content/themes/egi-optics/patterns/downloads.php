<?php
/**
 * Title: Downloads - technical documents
 * Slug: egi-optics/downloads
 * Categories: egi-optics
 * Description: Grid of datasheet download rows. Replace the file links with Media Library PDFs.
 * Viewport Width: 1400
 * Block Types: core/file
 *
 * @package EGI_Optics
 */

$egi_optics_docs = array(
	array( __( 'Night Vision Monocular NV/M-19 Gen 4', 'egi-optics' ), 'PDF Â· 221 KB' ),
	array( __( 'Thermal Vision Sight TVD-35', 'egi-optics' ), 'PDF Â· 141 KB' ),
	array( __( 'Laser Point LAD-21T', 'egi-optics' ), 'PDF Â· 125 KB' ),
	array( __( 'Laser Weapon System, Fenix Counter-UAV Complex and Remote Control Unit', 'egi-optics' ), 'PDF Â· 6.5 MB' ),
);
?>
<!-- wp:group {"align":"full","className":"egi-line-top","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull egi-line-top" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">
	<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"720px"}} -->
	<div class="wp-block-group alignwide egi-reveal" style="margin-bottom:var(--wp--preset--spacing--60)">
		<!-- wp:paragraph {"className":"egi-label"} -->
		<p class="egi-label"><?php echo esc_html__( 'Downloads', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"className":"egi-balance"} -->
		<h2 class="wp-block-heading egi-balance"><?php echo esc_html__( 'Technical documents.', 'egi-optics' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
		<p><?php echo esc_html__( 'Datasheets for our core systems. Detailed specifications, integration drawings and export documentation are available to qualified customers on request.', 'egi-optics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"wide","className":"egi-reveal-stagger","layout":{"type":"grid","minimumColumnWidth":"24rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
	<div class="wp-block-group alignwide egi-reveal-stagger">
		<?php foreach ( $egi_optics_docs as $egi_optics_doc ) : ?>
		<!-- wp:group {"className":"egi-download","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group egi-download">
			<?php echo egi_optics_icon_block( 'file-text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper escapes. ?>
			<!-- wp:group {"style":{"layout":{"selfStretch":"fill"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group">
				<!-- wp:file {"displayPreview":false,"showDownloadButton":true} -->
				<div class="wp-block-file"><a href="#"><?php echo esc_html( $egi_optics_doc[0] ); ?></a><a href="#" class="wp-block-file__button wp-element-button" download><?php echo esc_html__( 'Download', 'egi-optics' ); ?></a></div>
				<!-- /wp:file -->
				<!-- wp:paragraph {"className":"egi-download__meta"} -->
				<p class="egi-download__meta"><?php echo esc_html( $egi_optics_doc[1] ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
