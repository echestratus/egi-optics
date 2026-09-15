<?php
/**
 * 03 - Products: seven egi_product entries merging the holding-site data with the previous site's
 * datasheet tables. Content is generated as block markup with the theme's block styles.
 *
 * Run: wp eval-file scripts/content/03-products.php   (after 02-media.php)
 *
 * @package EGI_Optics_Content
 */

require_once __DIR__ . '/lib/bootstrap.php';
require_once __DIR__ . '/data/products.php';

egi_content_log( '== 03 products ==' );

/**
 * Build the block content of a product from its data array.
 *
 * @param array $p Product definition.
 * @return string
 */
function egi_content_build_product( array $p ) {
	$out = '';

	// Overview + benefits/applications.
	$left = egi_b_p( 'Overview', 'egi-label' )
		. egi_b_h( $p['overview_heading'], 2, '', 'xxxl' );
	foreach ( (array) $p['lead'] as $para ) {
		$left .= egi_b_p( $para, 'egi-lead' );
	}
	$right = egi_b_p( 'Key benefits', 'egi-label egi-label--muted' )
		. egi_b_list( $p['benefits'], 'egi-square' )
		. egi_b_p( 'Applications', 'egi-label egi-label--muted', array( 'style' => array( 'spacing' => array( 'margin' => array( 'top' => 'var:preset|spacing|50' ) ) ) ) )
		. egi_b_list( $p['applications'], 'egi-tags' );
	$out  .= egi_b_section( egi_b_columns( array( $left, $right ), '70', array( '58%', '42%' ) ), 'egi-product-section', '70', '40' );

	// Stats.
	if ( ! empty( $p['stats'] ) ) {
		$out .= egi_b_stats( $p['stats'] );
	}

	// Secondary image (full width) with caption.
	if ( ! empty( $p['image_secondary'] ) ) {
		$img = egi_b_image( $p['image_secondary'][0], $p['image_secondary'][1], $p['image_secondary'][2], 'is-style-egi-plain egi-media-frame egi-reveal', 'full' );
		if ( $img ) {
			$out .= '<!-- wp:group {"align":"wide","className":"egi-hud","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"default"}} --><div class="wp-block-group alignwide egi-hud" style="margin-top:var(--wp--preset--spacing--60)">' . $img . "</div><!-- /wp:group -->\n";
		}
	}

	// Spec groups (two per row).
	if ( ! empty( $p['specs'] ) ) {
		$groups = array();
		foreach ( $p['specs'] as $heading => $rows ) {
			$groups[] = egi_b_spec_group( $heading, $rows );
		}
		$inner = egi_b_p( 'Technical specifications', 'egi-label' );
		foreach ( array_chunk( $groups, 2 ) as $pair ) {
			$inner .= egi_b_columns( $pair, '40' );
		}
		if ( ! empty( $p['spec_note'] ) ) {
			$inner .= egi_b_p( $p['spec_note'], 'egi-mono', array( 'style' => array( 'typography' => array( 'fontSize' => 'var:preset|font-size|xs' ) ) ) );
		}
		$out .= '<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group alignwide egi-reveal" style="margin-top:var(--wp--preset--spacing--70)">' . $inner . "</div><!-- /wp:group -->\n";
	}

	// Detection tables (RCU).
	if ( ! empty( $p['tables'] ) ) {
		$cols = array();
		foreach ( $p['tables'] as $heading => $rows ) {
			$t = '<!-- wp:table {"className":"is-style-egi-spec"} --><figure class="wp-block-table is-style-egi-spec"><table><thead><tr><th>Drone</th><th>Detection</th><th>Recognition</th></tr></thead><tbody>';
			foreach ( $rows as $r ) {
				$t .= '<tr><td>' . egi_b_text( $r[0] ) . '</td><td>' . egi_b_text( $r[1] ) . '</td><td>' . egi_b_text( $r[2] ) . '</td></tr>';
			}
			$t     .= '</tbody></table></figure><!-- /wp:table -->';
			$cols[] = '<!-- wp:group {"className":"egi-spec-group","layout":{"type":"constrained"}} --><div class="wp-block-group egi-spec-group">' . egi_b_h( $heading, 3 ) . $t . '</div><!-- /wp:group -->';
		}
		$out .= '<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group alignwide egi-reveal" style="margin-top:var(--wp--preset--spacing--60)">'
			. egi_b_p( 'Detection and recognition ranges', 'egi-label' ) . egi_b_columns( $cols, '40' )
			. ( ! empty( $p['tables_note'] ) ? egi_b_p( $p['tables_note'], 'egi-mono', array( 'style' => array( 'typography' => array( 'fontSize' => 'var:preset|font-size|xs' ) ) ) ) : '' )
			. "</div><!-- /wp:group -->\n";
	}

	// Safety + advantages.
	if ( ! empty( $p['safety'] ) || ! empty( $p['advantages'] ) ) {
		$cols = array();
		if ( ! empty( $p['safety'] ) ) {
			$cols[] = '<!-- wp:group {"className":"is-style-egi-panel","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-egi-panel">' . egi_b_p( 'Integrated safety system', 'egi-label' ) . egi_b_list( $p['safety'], 'egi-check' ) . '</div><!-- /wp:group -->';
		}
		if ( ! empty( $p['advantages'] ) ) {
			$adv = '';
			foreach ( $p['advantages'] as $a ) {
				$adv .= '<!-- wp:group {"className":"is-style-egi-card","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-egi-card">' . egi_b_h( $a[0], 4, '', 'md' ) . egi_b_p( $a[1], '', array( 'style' => array( 'typography' => array( 'fontSize' => 'var:preset|font-size|sm' ) ) ) ) . '</div><!-- /wp:group -->';
			}
			$cols[] = egi_b_p( 'Competitive advantages', 'egi-label' ) . '<!-- wp:group {"layout":{"type":"grid","minimumColumnWidth":"12rem"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} --><div class="wp-block-group">' . $adv . '</div><!-- /wp:group -->';
		}
		$out .= '<!-- wp:group {"align":"wide","className":"egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group alignwide egi-reveal" style="margin-top:var(--wp--preset--spacing--60)">' . egi_b_columns( $cols, '40', count( $cols ) > 1 ? array( '40%', '60%' ) : array() ) . "</div><!-- /wp:group -->\n";
	}

	// Variant section (e.g. NV/G-14 goggles).
	if ( ! empty( $p['variant'] ) ) {
		$v     = $p['variant'];
		$left  = egi_b_p( $v['label'], 'egi-label' ) . egi_b_h( $v['title'], 2, '', 'xxxl' ) . egi_b_p( $v['text'], 'egi-lead' ) . egi_b_list( $v['benefits'], 'egi-square' );
		$right = egi_b_image( $v['image'][0], $v['image'][1], '', 'is-style-egi-frame egi-plate', 'large' );
		$out  .= egi_b_section( egi_b_columns( array( $left, $right ), '70', array( '55%', '45%' ) ), 'egi-line-top', '70', '40' );
		if ( ! empty( $v['specs'] ) ) {
			$groups = array();
			foreach ( $v['specs'] as $heading => $rows ) {
				$groups[] = egi_b_spec_group( $heading, $rows );
			}
			$inner = '';
			foreach ( array_chunk( $groups, 2 ) as $pair ) {
				$inner .= egi_b_columns( $pair, '40' );
			}
			$out .= '<!-- wp:group {"align":"wide","className":"egi-reveal","layout":{"type":"constrained"}} --><div class="wp-block-group alignwide egi-reveal">' . $inner . "</div><!-- /wp:group -->\n";
		}
	}

	// Gallery of extra images.
	if ( ! empty( $p['gallery'] ) ) {
		$imgs = '';
		foreach ( $p['gallery'] as $g ) {
			$imgs .= egi_b_image( $g[0], $g[1], $g[2] ?? '', 'is-style-egi-frame egi-plate', 'large' );
		}
		if ( $imgs ) {
			$out .= '<!-- wp:group {"align":"wide","className":"egi-reveal-stagger","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"grid","minimumColumnWidth":"18rem"}} --><div class="wp-block-group alignwide egi-reveal-stagger" style="margin-top:var(--wp--preset--spacing--70)">' . $imgs . "</div><!-- /wp:group -->\n";
		}
	}

	// Videos.
	foreach ( (array) ( $p['videos'] ?? array() ) as $video ) {
		$out .= egi_b_video_showcase( $video );
	}

	return $out;
}

$egi_order = 0;
foreach ( egi_content_products() as $egi_product ) {
	++$egi_order;
	$egi_datasheet_url  = $egi_product['datasheet'] ? egi_content_media_url( $egi_product['datasheet'] ) : '';
	$egi_datasheet_size = $egi_product['datasheet'] ? egi_content_media_size( $egi_product['datasheet'] ) : '';

	$egi_id = egi_content_upsert_post(
		array(
			'post_type'    => 'egi_product',
			'post_name'    => $egi_product['slug'],
			'post_title'   => $egi_product['title'],
			'post_excerpt' => $egi_product['excerpt'],
			'post_content' => egi_content_build_product( $egi_product ),
			'menu_order'   => $egi_order,
		),
		array(
			'egi_tagline'         => $egi_product['tagline'],
			'egi_accent'          => $egi_product['accent'],
			'egi_badge'           => $egi_product['badge'],
			'egi_datasheet_url'   => $egi_datasheet_url,
			'egi_datasheet_label' => $egi_datasheet_url ? sprintf( 'Download datasheet (PDF%s)', $egi_datasheet_size ? ', ' . $egi_datasheet_size : '' ) : '',
		)
	);

	wp_set_object_terms( $egi_id, $egi_product['category'], 'product_category' );

	$egi_thumb = egi_content_find_attachment( $egi_product['image'] );
	if ( $egi_thumb ) {
		set_post_thumbnail( $egi_id, $egi_thumb );
	}
}

egi_content_log( 'done.' );
