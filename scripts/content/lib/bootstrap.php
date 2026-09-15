<?php
/**
 * Shared helpers for the content migration scripts.
 *
 * Every script is run with:  wp eval-file scripts/content/<script>.php
 * They are idempotent: re-running updates existing content instead of duplicating it.
 *
 * Environment:
 *   EGI_ASSETS_DIR  directory with the prepared media (scripts/dev/prepare-assets.ps1 output).
 *                   Defaults to /var/www/html/egi-assets (wp-env mapping) or ~/egi-content-assets on the server.
 *
 * @package EGI_Optics_Content
 */

defined( 'WP_CLI' ) || exit( "Run with WP-CLI: wp eval-file <script>\n" );

if ( ! defined( 'EGI_CONTENT_LIB' ) ) {
	define( 'EGI_CONTENT_LIB', __DIR__ );

	/**
	 * Resolve the directory containing prepared media assets.
	 *
	 * @return string
	 */
	function egi_content_assets_dir() {
		$candidates = array(
			getenv( 'EGI_ASSETS_DIR' ),
			ABSPATH . 'egi-assets',
			getenv( 'HOME' ) . '/egi-content-assets',
		);
		foreach ( $candidates as $dir ) {
			if ( $dir && is_dir( $dir ) ) {
				return rtrim( $dir, '/' );
			}
		}
		return '';
	}

	/**
	 * Log helper.
	 *
	 * @param string $message Message.
	 */
	function egi_content_log( $message ) {
		WP_CLI::log( $message );
	}

	/**
	 * Create or update a post identified by slug + post type.
	 *
	 * @param array $data Post data (needs post_name, post_type, post_title).
	 * @param array $meta Meta key => value pairs.
	 * @return int Post ID.
	 */
	function egi_content_upsert_post( array $data, array $meta = array() ) {
		$existing = get_posts(
			array(
				'name'             => $data['post_name'],
				'post_type'        => $data['post_type'],
				'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'numberposts'      => 1,
				'fields'           => 'ids',
				'no_found_rows'    => true,
				'suppress_filters' => true,
			)
		);

		$data = wp_parse_args(
			$data,
			array(
				'post_status'    => 'publish',
				'post_author'    => egi_content_author_id(),
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
			)
		);

		// Pages: set the template explicitly. Existing pages may carry a template from the previous theme
		// (e.g. Elementor's "elementor_header_footer"), which wp_update_post() rejects as invalid.
		if ( 'page' === $data['post_type'] ) {
			$data['page_template'] = isset( $meta['_wp_page_template'] ) ? $meta['_wp_page_template'] : 'default';
			unset( $meta['_wp_page_template'] );
		}

		if ( $existing ) {
			$data['ID'] = (int) $existing[0];
			$post_id    = wp_update_post( wp_slash( $data ), true );
			$action     = 'updated';
		} else {
			$post_id = wp_insert_post( wp_slash( $data ), true );
			$action  = 'created';
		}

		if ( is_wp_error( $post_id ) ) {
			WP_CLI::error( sprintf( 'Failed to save %s "%s": %s', $data['post_type'], $data['post_title'], $post_id->get_error_message() ) );
		}

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		egi_content_log( sprintf( '  %s %s #%d %s (/%s/)', '•', $data['post_type'], $post_id, $action, $data['post_name'] ) );
		return (int) $post_id;
	}

	/**
	 * First administrator as author.
	 *
	 * @return int
	 */
	function egi_content_author_id() {
		static $id = null;
		if ( null === $id ) {
			$admins = get_users(
				array(
					'role'    => 'administrator',
					'number'  => 1,
					'orderby' => 'ID',
					'fields'  => 'ID',
				)
			);
			$id     = $admins ? (int) $admins[0] : 1;
		}
		return $id;
	}

	/**
	 * Find an attachment previously imported from a source file name.
	 *
	 * @param string $basename Source file name (e.g. laser-point-lad-21t.png).
	 * @return int Attachment ID or 0.
	 */
	function egi_content_find_attachment( $basename ) {
		$found = get_posts(
			array(
				'post_type'   => 'attachment',
				'post_status' => 'inherit',
				'numberposts' => 1,
				'fields'      => 'ids',
				'meta_key'    => '_egi_source', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => $basename, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);
		return $found ? (int) $found[0] : 0;
	}

	/**
	 * Import a prepared asset into the Media Library (once).
	 *
	 * @param string $basename File name inside the assets directory.
	 * @param array  $args     title, alt, caption, description.
	 * @return int Attachment ID (0 when the file is missing).
	 */
	function egi_content_import_media( $basename, array $args = array() ) {
		$existing = egi_content_find_attachment( $basename );
		if ( $existing ) {
			egi_content_update_media_text( $existing, $args );
			return $existing;
		}

		$dir  = egi_content_assets_dir();
		$path = $dir . '/' . $basename;
		if ( ! $dir || ! file_exists( $path ) ) {
			WP_CLI::warning( "Asset not found, skipped: {$basename}" );
			return 0;
		}

		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$tmp = wp_tempnam( $basename );
		copy( $path, $tmp );
		$file_array = array(
			'name'     => $basename,
			'tmp_name' => $tmp,
		);

		$post_data = array(
			'post_title'   => isset( $args['title'] ) ? $args['title'] : preg_replace( '/[-_]+/', ' ', pathinfo( $basename, PATHINFO_FILENAME ) ),
			'post_content' => isset( $args['description'] ) ? $args['description'] : '',
			'post_excerpt' => isset( $args['caption'] ) ? $args['caption'] : '',
		);

		$id = media_handle_sideload( $file_array, 0, null, $post_data );
		if ( is_wp_error( $id ) ) {
			WP_CLI::warning( "Import failed for {$basename}: " . $id->get_error_message() );
			return 0;
		}

		update_post_meta( $id, '_egi_source', $basename );
		if ( ! empty( $args['alt'] ) ) {
			update_post_meta( $id, '_wp_attachment_image_alt', $args['alt'] );
		}
		egi_content_log( sprintf( '  • media #%d imported %s', $id, $basename ) );
		return (int) $id;
	}

	/**
	 * Keep alt/caption in sync on re-runs.
	 *
	 * @param int   $id   Attachment ID.
	 * @param array $args title, alt, caption.
	 */
	function egi_content_update_media_text( $id, array $args ) {
		if ( ! empty( $args['alt'] ) ) {
			update_post_meta( $id, '_wp_attachment_image_alt', $args['alt'] );
		}
		$update = array( 'ID' => $id );
		if ( ! empty( $args['title'] ) ) {
			$update['post_title'] = $args['title'];
		}
		if ( isset( $args['caption'] ) ) {
			$update['post_excerpt'] = $args['caption'];
		}
		if ( count( $update ) > 1 ) {
			wp_update_post( $update );
		}
	}

	/**
	 * URL of an imported asset (empty string when missing).
	 *
	 * @param string $basename Source file name.
	 * @return string
	 */
	function egi_content_media_url( $basename ) {
		$id = egi_content_find_attachment( $basename );
		return $id ? (string) wp_get_attachment_url( $id ) : '';
	}

	/**
	 * Human readable file size of an imported asset.
	 *
	 * @param string $basename Source file name.
	 * @return string
	 */
	function egi_content_media_size( $basename ) {
		$id   = egi_content_find_attachment( $basename );
		$file = $id ? get_attached_file( $id ) : '';
		return ( $file && file_exists( $file ) ) ? size_format( filesize( $file ) ) : '';
	}

	/**
	 * Recursively expand <!-- wp:pattern {"slug":"..."} /--> into the registered pattern markup so
	 * page content is fully editable in the block editor.
	 *
	 * @param string $content Block markup.
	 * @param int    $depth   Recursion guard.
	 * @return string
	 */
	function egi_content_expand_patterns( $content, $depth = 0 ) {
		if ( $depth > 6 ) {
			return $content;
		}
		$registry = WP_Block_Patterns_Registry::get_instance();
		return preg_replace_callback(
			'/<!--\s+wp:pattern\s+({[^}]*})\s+\/-->/',
			static function ( $m ) use ( $registry, $depth ) {
				$attrs = json_decode( $m[1], true );
				$slug  = isset( $attrs['slug'] ) ? $attrs['slug'] : '';
				if ( ! $slug || ! $registry->is_registered( $slug ) ) {
					WP_CLI::warning( "Pattern not registered: {$slug}" );
					return '';
				}
				$pattern = $registry->get_registered( $slug );
				return "\n" . egi_content_expand_patterns( $pattern['content'], $depth + 1 ) . "\n";
			},
			$content
		);
	}

	/**
	 * Ensure a term exists and return its ID.
	 *
	 * @param string $name     Term name.
	 * @param string $taxonomy Taxonomy.
	 * @param string $slug     Slug.
	 * @param string $desc     Description.
	 * @return int
	 */
	function egi_content_ensure_term( $name, $taxonomy, $slug, $desc = '' ) {
		$term = get_term_by( 'slug', $slug, $taxonomy );
		if ( $term ) {
			if ( $desc && $term->description !== $desc ) {
				wp_update_term( $term->term_id, $taxonomy, array( 'description' => $desc ) );
			}
			return (int) $term->term_id;
		}
		$result = wp_insert_term(
			$name,
			$taxonomy,
			array(
				'slug'        => $slug,
				'description' => $desc,
			)
		);
		if ( is_wp_error( $result ) ) {
			WP_CLI::error( "Term {$name}: " . $result->get_error_message() );
		}
		egi_content_log( "  • term {$taxonomy}:{$slug} created" );
		return (int) $result['term_id'];
	}

	// ------------------------------------------------------------------
	// Block markup builders (keep content scripts readable).
	// ------------------------------------------------------------------

	/**
	 * Escape text for block HTML content.
	 *
	 * @param string $text Text.
	 * @return string
	 */
	function egi_b_text( $text ) {
		return wp_kses(
			$text,
			array(
				'strong' => array(),
				'em'     => array(),
				'br'     => array(),
				'a'      => array( 'href' => array() ),
				'sup'    => array(),
				'sub'    => array(),
			)
		);
	}

	/**
	 * Paragraph block.
	 *
	 * @param string $text  Text (may contain <strong>/<em>/<a>).
	 * @param string $css_class Extra class.
	 * @param array  $attrs Extra block attributes.
	 * @return string
	 */
	function egi_b_p( $text, $css_class = '', $attrs = array() ) {
		if ( $css_class ) {
			$attrs['className'] = $css_class;
		}
		$json = $attrs ? ' ' . wp_json_encode( $attrs ) : '';
		$cls  = $css_class ? ' class="' . esc_attr( $css_class ) . '"' : '';
		return "<!-- wp:paragraph{$json} --><p{$cls}>" . egi_b_text( $text ) . "</p><!-- /wp:paragraph -->\n";
	}

	/**
	 * Heading block.
	 *
	 * @param string $text  Text.
	 * @param int    $level Level.
	 * @param string $css_class Class.
	 * @param string $size  Font size preset slug (optional).
	 * @return string
	 */
	function egi_b_h( $text, $level = 2, $css_class = '', $size = '' ) {
		$attrs = array();
		if ( 2 !== $level ) {
			$attrs['level'] = $level;
		}
		if ( $css_class ) {
			$attrs['className'] = $css_class;
		}
		$style = '';
		if ( $size ) {
			$attrs['style'] = array( 'typography' => array( 'fontSize' => "var:preset|font-size|{$size}" ) );
			$style          = ' style="font-size:var(--wp--preset--font-size--' . $size . ')"';
		}
		$json = $attrs ? ' ' . wp_json_encode( $attrs ) : '';
		$cls  = 'wp-block-heading' . ( $css_class ? ' ' . esc_attr( $css_class ) : '' );
		return "<!-- wp:heading{$json} --><h{$level} class=\"{$cls}\"{$style}>" . egi_b_text( $text ) . "</h{$level}><!-- /wp:heading -->\n";
	}

	/**
	 * List block.
	 *
	 * @param array  $items Items.
	 * @param string $style Block style (egi-check, egi-square, egi-tags).
	 * @return string
	 */
	function egi_b_list( array $items, $style = 'egi-square' ) {
		$out = '<!-- wp:list {"className":"is-style-' . $style . '"} --><ul class="wp-block-list is-style-' . $style . '">';
		foreach ( $items as $item ) {
			$out .= '<!-- wp:list-item --><li>' . egi_b_text( $item ) . '</li><!-- /wp:list-item -->';
		}
		return $out . "</ul><!-- /wp:list -->\n";
	}

	/**
	 * Spec table block (label / value rows).
	 *
	 * @param array $rows Array of [label, value].
	 * @return string
	 */
	function egi_b_spec_table( array $rows ) {
		$out = '<!-- wp:table {"className":"is-style-egi-spec"} --><figure class="wp-block-table is-style-egi-spec"><table><tbody>';
		foreach ( $rows as $row ) {
			$out .= '<tr><td>' . egi_b_text( $row[0] ) . '</td><td>' . egi_b_text( $row[1] ) . '</td></tr>';
		}
		return $out . "</tbody></table></figure><!-- /wp:table -->\n";
	}

	/**
	 * Spec group card: heading + table.
	 *
	 * @param string $heading Group heading.
	 * @param array  $rows    Rows.
	 * @return string
	 */
	function egi_b_spec_group( $heading, array $rows ) {
		return '<!-- wp:group {"className":"egi-spec-group","layout":{"type":"constrained"}} --><div class="wp-block-group egi-spec-group">'
			. egi_b_h( $heading, 3 )
			. egi_b_spec_table( $rows )
			. "</div><!-- /wp:group -->\n";
	}

	/**
	 * Columns wrapper.
	 *
	 * @param array  $columns Array of inner markup strings.
	 * @param string $gap     Gap preset.
	 * @param array  $widths  Optional widths per column (e.g. '58%').
	 * @return string
	 */
	function egi_b_columns( array $columns, $gap = '40', array $widths = array() ) {
		$out = '<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|' . $gap . '","top":"var:preset|spacing|' . $gap . '"}}}} --><div class="wp-block-columns alignwide">';
		foreach ( $columns as $i => $inner ) {
			$w = isset( $widths[ $i ] ) ? $widths[ $i ] : '';
			if ( $w ) {
				$out .= '<!-- wp:column {"width":"' . $w . '"} --><div class="wp-block-column" style="flex-basis:' . $w . '">';
			} else {
				$out .= '<!-- wp:column --><div class="wp-block-column">';
			}
			$out .= $inner . '</div><!-- /wp:column -->';
		}
		return $out . "</div><!-- /wp:columns -->\n";
	}

	/**
	 * Stat tile.
	 *
	 * @param string $value Value.
	 * @param string $label Label.
	 * @return string
	 */
	function egi_b_stat( $value, $label ) {
		return '<!-- wp:group {"className":"egi-stat","layout":{"type":"constrained"}} --><div class="wp-block-group egi-stat">'
			. egi_b_p( $value, 'egi-stat__value' )
			. egi_b_p( $label, 'egi-stat__label' )
			. "</div><!-- /wp:group -->\n";
	}

	/**
	 * Grid of stat tiles.
	 *
	 * @param array $stats Array of [value, label].
	 * @return string
	 */
	function egi_b_stats( array $stats ) {
		$out = '<!-- wp:group {"align":"wide","className":"egi-cols-mobile-2 egi-reveal-stagger","style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"grid","minimumColumnWidth":"11rem"}} --><div class="wp-block-group alignwide egi-cols-mobile-2 egi-reveal-stagger" style="margin-top:var(--wp--preset--spacing--50)">';
		foreach ( $stats as $s ) {
			$out .= egi_b_stat( $s[0], $s[1] );
		}
		return $out . "</div><!-- /wp:group -->\n";
	}

	/**
	 * Image block from an imported asset.
	 *
	 * @param string $basename Asset file name.
	 * @param string $alt      Alt text.
	 * @param string $caption  Caption.
	 * @param string $css_class Extra class (e.g. is-style-egi-frame).
	 * @param string $size     Size slug.
	 * @return string
	 */
	function egi_b_image( $basename, $alt, $caption = '', $css_class = '', $size = 'large' ) {
		$id = egi_content_find_attachment( $basename );
		if ( ! $id ) {
			return '';
		}
		$src   = wp_get_attachment_image_url( $id, $size );
		$attrs = array(
			'id'              => $id,
			'sizeSlug'        => $size,
			'linkDestination' => 'none',
		);
		if ( $css_class ) {
			$attrs['className'] = $css_class;
		}
		$cls = 'wp-block-image size-' . $size . ( $css_class ? ' ' . esc_attr( $css_class ) : '' );
		$cap = $caption ? '<figcaption class="wp-element-caption">' . egi_b_text( $caption ) . '</figcaption>' : '';
		return '<!-- wp:image ' . wp_json_encode( $attrs ) . ' --><figure class="' . $cls . '"><img src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" class="wp-image-' . $id . '"/>' . $cap . "</figure><!-- /wp:image -->\n";
	}

	/**
	 * Video showcase (HUD frame) from an imported asset.
	 *
	 * @param array $v label, title, basename, poster, caption, meta (array of [label, value]).
	 * @return string
	 */
	function egi_b_video_showcase( array $v ) {
		$id = egi_content_find_attachment( $v['basename'] );
		if ( ! $id ) {
			return '';
		}
		$src    = wp_get_attachment_url( $id );
		$poster = ! empty( $v['poster'] ) ? egi_content_media_url( $v['poster'] ) : '';
		$pattr  = $poster ? ',"poster":"' . esc_url( $poster ) . '"' : '';
		$phtml  = $poster ? ' poster="' . esc_url( $poster ) . '"' : '';

		$chips = '';
		foreach ( (array) $v['meta'] as $m ) {
			$chips .= '<!-- wp:group {"className":"egi-meta-chip","layout":{"type":"constrained"}} --><div class="wp-block-group egi-meta-chip">'
				. egi_b_p( $m[0], 'egi-label' ) . egi_b_p( $m[1], 'egi-mono' )
				. '</div><!-- /wp:group -->';
		}

		return '<!-- wp:group {"className":"egi-video-section egi-reveal","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group egi-video-section egi-reveal" style="margin-top:var(--wp--preset--spacing--70)">'
			. '<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} --><div class="wp-block-group alignwide" style="margin-bottom:var(--wp--preset--spacing--50)">'
			. '<!-- wp:group {"layout":{"type":"constrained","justifyContent":"left","contentSize":"640px"}} --><div class="wp-block-group">'
			. egi_b_p( $v['label'], 'egi-label egi-pulse' )
			. egi_b_h( $v['title'], 3, '', 'xxxl' )
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} --><div class="wp-block-group">' . $chips . '</div><!-- /wp:group -->'
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","className":"egi-hud","layout":{"type":"default"}} --><div class="wp-block-group alignwide egi-hud">'
			. '<!-- wp:group {"className":"egi-video","layout":{"type":"default"}} --><div class="wp-block-group egi-video">'
			. '<!-- wp:html --><div class="egi-video__bar" aria-hidden="true"><span>REC · ' . esc_html( $v['bar'] ?? 'Field trial' ) . '</span><span>EGI Optik Indonesia</span></div><!-- /wp:html -->'
			. '<!-- wp:video {"id":' . $id . ',"preload":"metadata"' . $pattr . '} --><figure class="wp-block-video"><video controls preload="metadata" playsinline' . $phtml . ' src="' . esc_url( $src ) . '"></video></figure><!-- /wp:video -->'
			. '</div><!-- /wp:group -->'
			. '</div><!-- /wp:group -->'
			. '<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} --><div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)">'
			. egi_optics_icon_block( 'check' )
			. egi_b_p( $v['caption'], '', array( 'style' => array( 'layout' => array( 'selfStretch' => 'fill' ) ) ) )
			. '</div><!-- /wp:group -->'
			. "</div><!-- /wp:group -->\n";
	}

	/**
	 * Section wrapper (full width, constrained).
	 *
	 * @param string $inner   Inner blocks.
	 * @param string $css_class Extra classes.
	 * @param string $pad_top Padding top preset.
	 * @param string $pad_bot Padding bottom preset.
	 * @return string
	 */
	function egi_b_section( $inner, $css_class = '', $pad_top = '70', $pad_bot = '70' ) {
		$cls = trim( 'alignfull ' . $css_class );
		return '<!-- wp:group {"align":"full","className":"' . esc_attr( $css_class ) . '","style":{"spacing":{"padding":{"top":"var:preset|spacing|' . $pad_top . '","bottom":"var:preset|spacing|' . $pad_bot . '"}}},"layout":{"type":"constrained"}} -->'
			. '<div class="wp-block-group ' . esc_attr( $cls ) . '" style="padding-top:var(--wp--preset--spacing--' . $pad_top . ');padding-bottom:var(--wp--preset--spacing--' . $pad_bot . ')">'
			. $inner . "</div><!-- /wp:group -->\n";
	}
}
