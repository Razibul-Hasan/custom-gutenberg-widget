<?php
/**
 * Inserter previews: hovering one of our blocks in the inserter shows a picture of it as it looks on the live
 * site (assets/previews/<block>.jpg, made by tools/make-previews.mjs) instead of "No preview available".
 *
 * How: every bwe/* block with a picture gets a hidden attribute "bwePreview" and an "example" that sets it; the
 * editor script below shows the picture when that attribute is on. It is never saved (false = default), so no
 * page changes.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Preview picture file of a block ('' when none).
 *
 * @param string $name Block name.
 */
function bwe_gw_preview_file( $name ) {
	static $files = null;
	if ( 0 !== strpos( (string) $name, 'bwe/' ) ) {
		return '';
	}
	// One directory listing per request instead of a file check per block.
	$files = $files ?? array_flip( glob( BWE_GW_DIR . '/assets/previews/*.jpg' ) ?: array() );
	$file  = BWE_GW_DIR . '/assets/previews/' . substr( $name, 4 ) . '.jpg';
	return isset( $files[ $file ] ) ? $file : '';
}

/**
 * Adds the preview attribute and example to our blocks' metadata.
 *
 * @param array $metadata block.json data.
 */
function bwe_gw_preview_metadata( $metadata ) {
	if ( '' === bwe_gw_preview_file( $metadata['name'] ?? '' ) ) {
		return $metadata;
	}
	$metadata['attributes']['bwePreview'] = array(
		'type'    => 'boolean',
		'default' => false,
	);
	$metadata['example']                  = array(
		'attributes'    => array( 'bwePreview' => true ),
		'viewportWidth' => 900,
	);
	return $metadata;
}
add_filter( 'block_type_metadata', 'bwe_gw_preview_metadata' );

/**
 * Editor: shows the picture for a block whose bwePreview attribute is on (only the inserter's example sets it).
 */
function bwe_gw_preview_script() {
	$urls = array();
	foreach ( glob( BWE_GW_DIR . '/assets/previews/*.jpg' ) ?: array() as $file ) {
		$urls[ 'bwe/' . basename( $file, '.jpg' ) ] = plugins_url( 'assets/previews/' . basename( $file ), BWE_GW_DIR . '/bestwebexpert-gutenberg-widget.php' ) . '?v=' . filemtime( $file );
	}
	wp_add_inline_script(
		'wp-blocks',
		'( function () {'
		. 'if ( ! window.wp || ! wp.hooks || ! wp.element ) { return; }'
		. 'var urls = ' . wp_json_encode( $urls ) . ', el = wp.element.createElement;'
		. 'wp.hooks.addFilter( "blocks.registerBlockType", "bestwebexpert/previews", function ( settings, name ) {'
		. 'if ( ! urls[ name ] || ! settings.edit ) { return settings; }'
		. 'var Edit = settings.edit;'
		. 'var Preview = function () {'
		. 'return el( "div", wp.blockEditor.useBlockProps( { style: { margin: 0, padding: 0 } } ), el( "img", { src: urls[ name ], alt: "", style: { display: "block", width: "100%", height: "auto", borderRadius: 0 } } ) );'
		. '};'
		. 'return Object.assign( {}, settings, { edit: function ( props ) { return props.attributes && props.attributes.bwePreview ? el( Preview, props ) : el( Edit, props ); } } );'
		. '} );'
		. '} )();'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_preview_script' );
