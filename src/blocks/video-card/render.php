<?php
/**
 * One video testimonial: a YouTube link (BestWebExpert Home turns it into the click-to-play 9:16 thumbnail) and
 * the "who" line under it.
 *
 * @package BWE_Gutenberg_Widget
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$bwe_url = bwe_gw_attr( $attributes, 'url' );
$bwe_who = bwe_gw_attr( $attributes, 'who' );

// The embed as the core Embed block saved it; on the live page BestWebExpert Home swaps it for the facade.
$bwe_saved = '<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube bwex-vt__video"><div class="wp-block-embed__wrapper">' . "\n" . esc_url( $bwe_url ) . "\n" . '</div></figure>';
$bwe_video = $bwe_saved;
if ( '' !== $bwe_url && ! bwe_gw_readers_mode() ) {
	$bwe_video = apply_filters(
		'render_block_core/embed',
		$bwe_saved,
		array(
			'blockName' => 'core/embed',
			'attrs'     => array(
				'url'              => $bwe_url,
				'type'             => 'video',
				'providerNameSlug' => 'youtube',
				'responsive'       => true,
				'className'        => 'bwex-vt__video',
			),
		)
	);
	if ( $bwe_video === $bwe_saved ) { // Not a YouTube link: a normal oEmbed player.
		$bwe_embed = wp_oembed_get( $bwe_url );
		$bwe_video = '<figure class="wp-block-embed bwex-vt__video"><div class="wp-block-embed__wrapper">' . ( $bwe_embed ? $bwe_embed : '<a href="' . esc_url( $bwe_url ) . '">' . esc_html( $bwe_url ) . '</a>' ) . '</div></figure>';
	}
}

echo bwe_gw_group( 'bwex-vt', ( '' !== $bwe_url ? $bwe_video : '' ) . ( '' !== $bwe_who ? bwe_gw_p( 'bwex-vt__who', $bwe_who ) : '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above; facade built by BestWebExpert Home.
