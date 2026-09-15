/**
 * "Product details" sidebar panel for the egi_product post type.
 *
 * Written without JSX so it needs no build step; relies on the globals
 * WordPress already loads in the block editor.
 *
 * @param {Object} wp The global `wp` namespace.
 */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.plugins || ! wp.element ) {
		return;
	}

	const { registerPlugin } = wp.plugins;
	const { createElement: el, Fragment } = wp.element;
	const { TextControl, SelectControl, PanelRow } = wp.components;
	const { useSelect } = wp.data;
	const { useEntityProp } = wp.coreData;
	const { __ } = wp.i18n;
	const config = window.egiCoreProduct || {};
	const PluginDocumentSettingPanel =
		( wp.editor && wp.editor.PluginDocumentSettingPanel ) ||
		( wp.editPost && wp.editPost.PluginDocumentSettingPanel );

	if ( ! PluginDocumentSettingPanel ) {
		return;
	}

	const ACCENT_LABELS = {
		primary: __( 'Blue (primary)', 'egi-optics-core' ),
		accent: __( 'Cyan', 'egi-optics-core' ),
		amber: __( 'Amber', 'egi-optics-core' ),
		emerald: __( 'Emerald', 'egi-optics-core' ),
		violet: __( 'Violet', 'egi-optics-core' ),
		rose: __( 'Rose', 'egi-optics-core' ),
	};

	function ProductDetailsPanel() {
		const postType = useSelect(
			( select ) => select( 'core/editor' ).getCurrentPostType(),
			[]
		);
		const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );

		if ( postType !== config.postType || ! meta ) {
			return null;
		}

		const update = ( key ) => ( value ) =>
			setMeta( { ...meta, [ key ]: value } );

		const accents = ( config.accents || [ 'primary' ] ).map( ( slug ) => ( {
			value: slug,
			label: ACCENT_LABELS[ slug ] || slug,
		} ) );

		return el(
			PluginDocumentSettingPanel,
			{
				name: 'egi-product-details',
				title: __( 'Product details', 'egi-optics-core' ),
				className: 'egi-product-details-panel',
			},
			el(
				Fragment,
				null,
				el(
					PanelRow,
					null,
					el( TextControl, {
						label: __( 'Tagline', 'egi-optics-core' ),
						help: __(
							'Shown under the product name. Keep it under 60 characters.',
							'egi-optics-core'
						),
						value: meta.egi_tagline || '',
						onChange: update( 'egi_tagline' ),
						__nextHasNoMarginBottom: true,
						__next40pxDefaultSize: true,
					} )
				),
				el(
					PanelRow,
					null,
					el( TextControl, {
						label: __( 'Card badge', 'egi-optics-core' ),
						help: __(
							'Optional, e.g. "Field-proven" or "New".',
							'egi-optics-core'
						),
						value: meta.egi_badge || '',
						onChange: update( 'egi_badge' ),
						__nextHasNoMarginBottom: true,
						__next40pxDefaultSize: true,
					} )
				),
				el(
					PanelRow,
					null,
					el( TextControl, {
						label: __( 'Datasheet URL (PDF)', 'egi-optics-core' ),
						type: 'url',
						value: meta.egi_datasheet_url || '',
						onChange: update( 'egi_datasheet_url' ),
						__nextHasNoMarginBottom: true,
						__next40pxDefaultSize: true,
					} )
				),
				el(
					PanelRow,
					null,
					el( TextControl, {
						label: __(
							'Datasheet button label',
							'egi-optics-core'
						),
						value: meta.egi_datasheet_label || '',
						onChange: update( 'egi_datasheet_label' ),
						__nextHasNoMarginBottom: true,
						__next40pxDefaultSize: true,
					} )
				),
				el(
					PanelRow,
					null,
					el( SelectControl, {
						label: __( 'Accent colour', 'egi-optics-core' ),
						value: meta.egi_accent || 'primary',
						options: accents,
						onChange: update( 'egi_accent' ),
						__nextHasNoMarginBottom: true,
						__next40pxDefaultSize: true,
					} )
				)
			)
		);
	}

	registerPlugin( 'egi-core-product-details', {
		render: ProductDetailsPanel,
		icon: 'visibility',
	} );
} )( window.wp );
