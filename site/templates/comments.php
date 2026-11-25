<?php
/**
 * Comments on single posts: the conversation, then the form.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}

$bwe_count = (int) get_comments_number();
?>
<section id="comments" class="bwe-section bwe-comments" aria-labelledby="bwe-comments-title">
	<div class="bwe-comments__inner">
		<h2 id="bwe-comments-title" class="wp-block-heading bwe-comments__title">
			<?php
			esc_html_e( 'Comments', 'bestwebexpert-home' );
			if ( $bwe_count ) {
				echo ' <span class="bwe-comments__count">' . esc_html( number_format_i18n( $bwe_count ) ) . '</span>';
			}
			?>
		</h2>

		<?php if ( have_comments() ) : ?>
			<ol class="bwe-comment-list">
				<?php
				wp_list_comments(
					array(
						'style'      => 'ol',
						'callback'   => 'bwe_blog_comment',
						'short_ping' => true,
					)
				);
				?>
			</ol>

			<?php
			the_comments_pagination(
				array(
					'class'     => 'bwe-comment-pager',
					'prev_text' => __( '← Older comments', 'bestwebexpert-home' ),
					'next_text' => __( 'Newer comments →', 'bestwebexpert-home' ),
				)
			);
			?>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
			<p class="bwe-comments__closed"><?php esc_html_e( 'Comments are closed on this post.', 'bestwebexpert-home' ); ?></p>
		<?php endif; ?>

		<?php
		comment_form(
			array(
				'class_container'      => 'comment-respond bwe-respond',
				'class_form'           => 'comment-form bwe-form',
				'title_reply'          => __( 'Leave a comment', 'bestwebexpert-home' ),
				/* translators: %s: comment author name. */
				'title_reply_to'       => __( 'Reply to %s', 'bestwebexpert-home' ),
				'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title bwe-respond__title">',
				'title_reply_after'    => '</h3>',
				'cancel_reply_link'    => __( 'Cancel reply', 'bestwebexpert-home' ),
				'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Your email stays private. Fields marked * are required.', 'bestwebexpert-home' ) . '</p>',
				'label_submit'         => __( 'Post comment', 'bestwebexpert-home' ),
				'class_submit'         => 'submit bwe-submit',
			)
		);
		?>
	</div>
</section>
