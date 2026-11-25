<?php
/**
 * Style settings for blocks (Styles tab): each block's block.json has a "bweStyleMap" — a list of settings
 * (key, label, panel, control) and the CSS each one writes. Values live in the block attribute "bweStyle".
 * Only settings that have a value produce CSS, so an untouched block prints exactly its normal markup.
 *
 * The CSS is scoped to one block (class bwe-s-<hash>) and written as
 *   html body .bwe-s-…:not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c) <part>{prop:value!important}
 * — three ID-weights + !important, so it also beats the site's own !important rules (the Customizer hero
 * background uses two). The same engine runs in the editor (src/blocks/shared/style-engine.js).
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

const BWE_GW_STYLE_MEDIA = array(
	'desktop' => '@media (min-width:1025px)',
	'tablet' => '@media (max-width:1024px)',
	'mobile' => '@media (max-width:781px)',
);

/**
 * Makes a user-entered value safe inside a CSS declaration (no way to close the rule or the <style> element).
 *
 * @param mixed $value Raw value.
 */
function bwe_gw_style_clean( $value ) {
	if ( is_bool( $value ) ) {
		return $value ? 'true' : '';
	}
	return trim( preg_replace( '/[<>{};\\\\"\r\n]/', '', (string) $value ) );
}

/**
 * CSS for one block instance.
 *
 * @param array  $map    The block's style map.
 * @param array  $values Saved style values (attribute bweStyle).
 * @param string $class  Scope class.
 */
function bwe_gw_style_css( array $map, array $values, $class ) {
	$scope  = 'html body .' . $class . ':not(#bwe-gw-a):not(#bwe-gw-b):not(#bwe-gw-c)';
	$groups = array(); // media => selector => declarations.
	foreach ( $map as $setting ) {
		$value = bwe_gw_style_clean( $values[ $setting['key'] ] ?? '' );
		if ( '' === $value ) {
			continue;
		}
		foreach ( $setting['rules'] as $rule ) {
			if ( isset( $rule['fixed'] ) ) {
				$css_value = $rule['fixed'];
			} elseif ( isset( $rule['valueMap'] ) ) {
				if ( ! isset( $rule['valueMap'][ $value ] ) ) {
					continue;
				}
				$css_value = $rule['valueMap'][ $value ];
			} else {
				$css_value = str_replace( '{v}', $value, $rule['tpl'] ?? '{v}' );
			}
			$media                                  = $rule['media'] ?? '';
			$groups[ $media ][ $rule['sel'] ?? '' ][] = $rule['prop'] . ':' . $css_value . '!important';
		}
	}
	$css = '';
	foreach ( $groups as $media => $selectors ) {
		$block = '';
		foreach ( $selectors as $sel => $decls ) {
			$block .= $scope . $sel . '{' . implode( ';', $decls ) . '}';
		}
		$css .= '' === $media ? $block : BWE_GW_STYLE_MEDIA[ $media ] . '{' . $block . '}';
	}
	return $css;
}

/**
 * The style map of a built block (read from its block.json once per request).
 *
 * @param string $block_dir Directory of the block's block.json.
 */
function bwe_gw_style_map( $block_dir ) {
	static $maps = array();
	if ( ! isset( $maps[ $block_dir ] ) ) {
		// From the build manifest (no file read); the block's own block.json when there is no manifest entry.
		$manifest = function_exists( 'bwe_blocks_manifest' ) ? bwe_blocks_manifest() : array();
		$json     = $manifest[ basename( $block_dir ) ] ?? json_decode( (string) file_get_contents( $block_dir . '/block.json' ), true );
		$maps[ $block_dir ] = is_array( $json['bweStyleMap'] ?? null ) ? $json['bweStyleMap'] : array();
	}
	return $maps[ $block_dir ];
}

/**
 * Scope class + <style> element for a block's style settings ('' / '' when nothing is set).
 *
 * @param string $block_dir  Directory of the block's block.json.
 * @param array  $attributes Block attributes.
 * @return array{0: string, 1: string} [ class, style element ]
 */
function bwe_gw_style_for_block( $block_dir, array $attributes ) {
	$values = is_array( $attributes['bweStyle'] ?? null ) ? $attributes['bweStyle'] : array();
	if ( ! $values ) {
		return array( '', '' );
	}
	$class = 'bwe-s-' . substr( md5( (string) wp_json_encode( $values ) ), 0, 10 );
	$css   = bwe_gw_style_css( bwe_gw_style_map( $block_dir ), $values, $class );
	return '' === $css ? array( '', '' ) : array( $class, '<style>' . $css . '</style>' );
}
