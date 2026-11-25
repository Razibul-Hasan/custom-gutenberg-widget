<?php
/**
 * Contact form section (bwe/contact-form): the Contact Form 7 forms the editor can pick, and a live preview of the
 * chosen form for the editor canvas.
 *
 * @package BWE_Gutenberg_Widget
 */

defined( 'ABSPATH' ) || exit;

/**
 * Contact Form 7 forms as [ { title, shortcode } ] (empty without CF7).
 */
function bwe_gw_cf7_forms() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return array();
	}
	$forms = array();
	foreach ( get_posts( array( 'post_type' => 'wpcf7_contact_form', 'numberposts' => 50, 'orderby' => 'title', 'order' => 'ASC' ) ) as $post ) {
		$form = WPCF7_ContactForm::get_instance( $post );
		if ( ! $form ) {
			continue;
		}
		$id      = method_exists( $form, 'hash' ) ? substr( (string) $form->hash(), 0, 7 ) : (string) $post->ID;
		$forms[] = array(
			'title'     => $post->post_title,
			'shortcode' => sprintf( '[contact-form-7 id="%s" title="%s"]', $id, str_replace( '"', '', $post->post_title ) ),
		);
	}
	return $forms;
}

/**
 * The form list for the editor (window.bweGw.cf7Forms).
 */
function bwe_gw_cf7_forms_editor_data() {
	wp_add_inline_script(
		'wp-blocks',
		'window.bweGw = Object.assign( window.bweGw || {}, ' . wp_json_encode( array( 'cf7Forms' => bwe_gw_cf7_forms() ) ) . ' );',
		'before'
	);
}
add_action( 'enqueue_block_editor_assets', 'bwe_gw_cf7_forms_editor_data' );

/**
 * GET /bwe-gw/v1/form-preview?form=[contact-form-7 …] — the form's HTML for the editor canvas (editors only; only
 * Contact Form 7 shortcodes are run).
 */
function bwe_gw_form_preview_route() {
	register_rest_route(
		'bwe-gw/v1',
		'/form-preview',
		array(
			'methods'             => 'GET',
			'permission_callback' => static fn() => current_user_can( 'edit_posts' ),
			'args'                => array( 'form' => array( 'type' => 'string', 'required' => true ) ),
			'callback'            => static function ( WP_REST_Request $request ) {
				$form = trim( (string) $request->get_param( 'form' ) );
				if ( ! preg_match( '/^\[contact-form-7\s[^\]]*\]$/', $form ) ) {
					return array( 'html' => '' );
				}
				return array( 'html' => do_shortcode( $form ) );
			},
		)
	);
}
add_action( 'rest_api_init', 'bwe_gw_form_preview_route' );
