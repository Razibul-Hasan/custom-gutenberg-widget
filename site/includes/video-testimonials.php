<?php
/**
 * Video testimonials (2026-11-20).
 *
 * In the editor each testimonial is an ordinary YouTube embed block with the class "bwex-vt__video":
 * paste a Shorts link (youtube.com/shorts/ID), a watch link or a youtu.be link to change the video.
 * On the front end the block is rendered as a 9:16 thumbnail with a play button; the YouTube player
 * (youtube-nocookie.com) only loads after a click, so the page stays fast.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pull the 11-character video ID out of any YouTube URL.
 *
 * @param string $url YouTube URL.
 * @return string Video ID or ''.
 */
function bwe_vt_youtube_id( $url ) {
	if ( preg_match( '~(?:youtube(?:-nocookie)?\.com/(?:shorts/|embed/|live/|watch\?(?:.*&)?v=)|youtu\.be/)([A-Za-z0-9_-]{11})~', (string) $url, $m ) ) {
		return $m[1];
	}
	return '';
}

/**
 * Swap the testimonial embeds for a click-to-play facade.
 */
add_filter(
	'render_block_core/embed',
	function ( $html, $block ) {
		$class = isset( $block['attrs']['className'] ) ? (string) $block['attrs']['className'] : '';
		if ( is_admin() || false === strpos( $class, 'bwex-vt__video' ) ) {
			return $html;
		}
		$id = bwe_vt_youtube_id( isset( $block['attrs']['url'] ) ? $block['attrs']['url'] : '' );
		if ( '' === $id ) {
			return $html;
		}
		wp_enqueue_style( 'bwe-vt' );
		wp_enqueue_script( 'bwe-vt' );

		return sprintf(
			'<figure class="bwex-vt__video"><button type="button" class="bwex-yt" data-yt="%1$s" aria-label="%2$s"><img src="https://i.ytimg.com/vi/%1$s/oardefault.jpg" data-fb="https://i.ytimg.com/vi/%1$s/oar2.jpg https://i.ytimg.com/vi/%1$s/hqdefault.jpg" onload="if(this.naturalWidth&lt;=120)this.onerror()" onerror="var f=(this.dataset.fb||\'\').split(\' \'),u=f.shift();this.dataset.fb=f.join(\' \');if(u){this.src=u}else{this.onload=this.onerror=null}" alt="%3$s" width="1080" height="1920" loading="lazy" decoding="async"><span class="bwex-yt__play" aria-hidden="true"></span></button></figure>',
			esc_attr( $id ),
			esc_attr__( 'Play client video testimonial', 'bestwebexpert' ),
			// A real alt: an empty one gets filled by Rank Math's "add missing alt" with the file name ("oardefault").
			esc_attr__( 'Client video testimonial', 'bestwebexpert' )
		);
	},
	10,
	2
);

add_action(
	'wp_enqueue_scripts',
	function () {
		$dir = BWE_HOME_DIR . '/assets/';
		$url = plugins_url( 'assets/', BWE_HOME_DIR . '/site.php' );
		wp_register_style( 'bwe-vt', $url . 'video-testimonials.css', array(), (string) filemtime( $dir . 'video-testimonials.css' ) );
		wp_register_script( 'bwe-vt', $url . 'video-testimonials.js', array(), (string) filemtime( $dir . 'video-testimonials.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	},
	5
);
