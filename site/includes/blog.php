<?php
/**
 * Blog: the posts page, post archives and single posts in the BestWebExpert design.
 *
 * The posts page renders the Blog page's own block content (the "BestWebExpert – Blog page" pattern),
 * so its header, post grid and call to action stay editable in the block editor. Category, tag, author and
 * date archives reuse that content with a header of their own. Single posts and comments use the plugin's
 * templates inside Astra's header and footer.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

/**
 * Which blog view the current request is.
 *
 * @return string 'archive', 'single' or '' for anything else.
 */
function bwe_blog_view() {
	if ( is_admin() ) {
		return '';
	}

	if ( is_singular( 'post' ) ) {
		return 'single';
	}

	if ( is_home() || is_category() || is_tag() || is_author() || is_date() ) {
		return 'archive';
	}

	return '';
}

/**
 * Full-width, sidebar-free Astra layout for the blog views, like the home page.
 *
 * @param string $layout Astra content layout.
 * @return string
 */
function bwe_blog_content_layout( $layout ) {
	return bwe_blog_view() ? 'page-builder' : $layout;
}
add_filter( 'astra_get_content_layout', 'bwe_blog_content_layout' );

/**
 * Removes Astra's sidebar on the blog views.
 *
 * @param string $layout Astra sidebar layout.
 * @return string
 */
function bwe_blog_page_layout( $layout ) {
	return bwe_blog_view() ? 'no-sidebar' : $layout;
}
add_filter( 'astra_page_layout', 'bwe_blog_page_layout' );

/**
 * Swaps in the plugin's archive and single post templates.
 *
 * @param string $template Template path WordPress picked.
 * @return string
 */
function bwe_blog_template( $template ) {
	$view = bwe_blog_view();

	if ( $view ) {
		return BWE_HOME_DIR . '/templates/' . $view . '.php';
	}

	return $template;
}
add_filter( 'template_include', 'bwe_blog_template', 20 );

/**
 * Uses the plugin's comments template on single posts.
 *
 * @param string $template Comments template path.
 * @return string
 */
function bwe_blog_comments_template( $template ) {
	return 'single' === bwe_blog_view() ? BWE_HOME_DIR . '/templates/comments.php' : $template;
}
add_filter( 'comments_template', 'bwe_blog_comments_template' );

/**
 * Drops Astra's comment form rewrite on single posts, so the form keeps WordPress's visible labels.
 */
function bwe_blog_plain_comment_form() {
	if ( 'single' === bwe_blog_view() ) {
		remove_filter( 'comment_form_default_fields', 'astra_comment_form_default_fields_markup' );
		remove_filter( 'comment_form_defaults', 'astra_comment_form_default_markup' );
	}
}
add_action( 'template_redirect', 'bwe_blog_plain_comment_form' );

/**
 * Sends the blog's old address, /blog/ and its /page/N/ pages, to the posts page's current address.
 *
 * The posts page moved to /wordpress-and-shopify-tips/ (2026-10-15) so its URL carries the focus keyword.
 * WordPress doesn't track old slugs for pages, so the redirect lives here.
 */
function bwe_blog_old_url_redirect() {
	if ( ! is_404() ) {
		return;
	}

	$page_id = (int) get_option( 'page_for_posts' );
	if ( ! $page_id || 'blog' === get_post_field( 'post_name', $page_id ) ) {
		return;
	}

	$path = (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '', PHP_URL_PATH );
	$base = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	$path = trim( substr( $path, strlen( $base ) ), '/' );

	if ( ! preg_match( '#^blog(?:/page/(\d+))?$#', $path, $match ) ) {
		return;
	}

	$url = get_permalink( $page_id );
	if ( ! empty( $match[1] ) && (int) $match[1] > 1 ) {
		$url = trailingslashit( $url ) . user_trailingslashit( 'page/' . (int) $match[1], 'paged' );
	}

	wp_safe_redirect( $url, 301 );
	exit;
}
add_action( 'template_redirect', 'bwe_blog_old_url_redirect', 1 );

/**
 * Loads the threaded-reply script where replies are possible.
 */
function bwe_blog_enqueue_scripts() {
	if ( 'single' === bwe_blog_view() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bwe_blog_enqueue_scripts' );

/**
 * Estimated reading time of a post.
 *
 * @param int|WP_Post|null $post Post.
 * @return int Minutes, at least 1.
 */
function bwe_blog_reading_time( $post = null ) {
	$words = str_word_count( wp_strip_all_tags( (string) get_post_field( 'post_content', $post ) ) );
	return max( 1, (int) ceil( $words / 220 ) );
}

/**
 * "4 min read" label.
 *
 * @param int|WP_Post|null $post Post.
 * @return string
 */
function bwe_blog_reading_label( $post = null ) {
	/* translators: %d: minutes. */
	return sprintf( __( '%d min read', 'bestwebexpert-home' ), bwe_blog_reading_time( $post ) );
}

/**
 * The post's H2 headings that carry an id, for the "On this page" list.
 *
 * @param string $html Rendered post content.
 * @return array<int, array{id: string, title: string}>
 */
function bwe_blog_toc_items( $html ) {
	preg_match_all( '#<h2\b[^>]*\bid="([^"]+)"[^>]*>(.*?)</h2>#is', $html, $matches, PREG_SET_ORDER );

	$items = array();
	foreach ( $matches as $match ) {
		$title = trim( wp_strip_all_tags( $match[2] ) );
		if ( '' !== $title ) {
			$items[] = array(
				'id'    => $match[1],
				'title' => $title,
			);
		}
	}

	return $items;
}

/**
 * Adds the reading time to the date on post cards.
 *
 * @param string   $content Block HTML.
 * @param array    $block   Parsed block.
 * @param WP_Block $instance Block instance.
 * @return string
 */
function bwe_blog_card_date( $content, $block, $instance ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'bwe-card__date' ) || empty( $instance->context['postId'] ) ) {
		return $content;
	}

	$label = '<span class="bwe-card__read">' . esc_html( bwe_blog_reading_label( $instance->context['postId'] ) ) . '</span>';
	$pos   = strrpos( $content, '</div>' );

	return false === $pos ? $content : substr_replace( $content, $label . '</div>', $pos, 6 );
}
add_filter( 'render_block_core/post-date', 'bwe_blog_card_date', 10, 3 );

/**
 * Query Loop block markup for a grid of post cards.
 *
 * @param array  $query       Query attributes, merged over the defaults.
 * @param string $classname   Extra class for the query block.
 * @param bool   $paginate    Whether to add pagination and an empty state.
 * @param int    $title_level Heading level of the post titles.
 * @return string Block markup.
 */
function bwe_blog_query_markup( $query = array(), $classname = 'bwe-posts', $paginate = true, $title_level = 2 ) {
	$query = array_merge(
		array(
			'perPage'  => 9,
			'pages'    => 0,
			'offset'   => 0,
			'postType' => 'post',
			'order'    => 'desc',
			'orderBy'  => 'date',
			'author'   => '',
			'search'   => '',
			'exclude'  => array(),
			'sticky'   => '',
			'inherit'  => true,
		),
		$query
	);

	$attrs = wp_json_encode(
		array(
			'queryId'   => 1,
			'query'     => $query,
			'className' => $classname,
		),
		JSON_UNESCAPED_SLASHES
	);

	$card = '<!-- wp:post-template {"className":"bwe-posts__grid"} -->
<!-- wp:group {"className":"bwe-card"} -->
<div class="wp-block-group bwe-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","sizeSlug":"large","className":"bwe-card__img"} /-->

<!-- wp:group {"className":"bwe-card__body"} -->
<div class="wp-block-group bwe-card__body"><!-- wp:post-terms {"term":"category","className":"bwe-card__cat"} /-->

<!-- wp:post-title {"level":' . (int) $title_level . ',"isLink":true,"className":"bwe-card__title"} /-->

<!-- wp:post-excerpt {"excerptLength":22,"className":"bwe-card__excerpt"} /-->

<!-- wp:post-date {"className":"bwe-card__date"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->';

	$more = '';
	if ( $paginate ) {
		$more = '

<!-- wp:query-pagination {"paginationArrow":"arrow","className":"bwe-pager"} -->
<!-- wp:query-pagination-previous {"label":"Newer"} /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next {"label":"Older"} /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"className":"bwe-empty"} -->
<p class="bwe-empty">Nothing here yet. Fresh tips are on the way, so check back soon.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->';
	}

	return '<!-- wp:query ' . $attrs . ' -->
<div class="wp-block-query ' . esc_attr( $classname ) . '">' . $card . $more . '</div>
<!-- /wp:query -->';
}

/**
 * Header block markup for category, tag, author and date archives.
 *
 * @return string Block markup.
 */
function bwe_blog_archive_head_markup() {
	$eyebrow     = __( 'Archive', 'bestwebexpert-home' );
	$title       = wp_strip_all_tags( get_the_archive_title() );
	$description = wp_strip_all_tags( get_the_archive_description() );

	if ( is_category() || is_tag() ) {
		$eyebrow = is_category() ? __( 'Category', 'bestwebexpert-home' ) : __( 'Tag', 'bestwebexpert-home' );
		$title   = single_term_title( '', false );
	} elseif ( is_author() ) {
		$eyebrow = __( 'Author', 'bestwebexpert-home' );
		$title   = get_the_author_meta( 'display_name', (int) get_queried_object_id() );
	}

	if ( ! $description ) {
		/* translators: %s: archive name. */
		$description = sprintf( __( 'Every tip we’ve published under “%s”.', 'bestwebexpert-home' ), $title );
	}

	$blog = (int) get_option( 'page_for_posts' );
	$back = $blog ? get_permalink( $blog ) : home_url( '/' );

	return '<!-- wp:group {"tagName":"section","className":"bwe-section bwe-blog-head"} -->
<section class="wp-block-group bwe-section bwe-blog-head"><!-- wp:paragraph {"className":"bwe-back"} -->
<p class="bwe-back"><a href="' . esc_url( $back ) . '">' . esc_html__( '← All posts', 'bestwebexpert-home' ) . '</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"bwe-eyebrow"} -->
<p class="bwe-eyebrow">' . esc_html( $eyebrow ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"bwe-blog-head__title"} -->
<h1 class="wp-block-heading bwe-blog-head__title">' . esc_html( $title ) . '</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"bwe-lead"} -->
<p class="bwe-lead">' . esc_html( $description ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:categories {"className":"bwe-cats"} /--></section>
<!-- /wp:group -->';
}

/**
 * Block content for the current archive: the Blog page's content, with its own header on non-blog archives.
 *
 * @return string Block markup.
 */
function bwe_blog_archive_content() {
	$page_id = (int) get_option( 'page_for_posts' );
	// Expanded: the Blog page's sections are synced patterns (2026-11-21).
	$content = $page_id ? bwe_post_content_expanded( $page_id ) : '';
	// Its page-wide wrapper comes from the page's Page layout setting (BestWebExpert Gutenberg Widget, 2026-11-25).
	if ( $page_id && function_exists( 'bwe_gw_page_layout_markup' ) ) {
		$content = bwe_gw_page_layout_markup( $page_id, $content );
	}

	// Fall back to the pattern if the Blog page has no post grid yet.
	if ( false === strpos( $content, '<!-- wp:query' ) ) {
		$content = bwe_home_get_pattern_content( 'blog' );
	}

	if ( is_home() ) {
		return $content;
	}

	// Replace the first section of the wrapper (the header) with one for this archive.
	$blocks = parse_blocks( $content );
	foreach ( $blocks as $i => $block ) {
		if ( ! empty( $block['innerBlocks'] ) ) {
			$head                            = parse_blocks( bwe_blog_archive_head_markup() );
			$blocks[ $i ]['innerBlocks'][0] = $head[0];
			break;
		}
	}

	return serialize_blocks( $blocks );
}

/**
 * Up to three posts to read next: same category first, then the latest.
 *
 * @param int $post_id Current post ID.
 * @return string Block markup, or '' when there are no other posts.
 */
function bwe_blog_related_markup( $post_id ) {
	$cats  = wp_get_post_categories( $post_id );
	$query = array(
		'perPage' => 3,
		'inherit' => false,
		'exclude' => array( $post_id ),
	);

	$same_category = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 1,
			'post__not_in'        => array( $post_id ),
			'category__in'        => $cats,
			'ignore_sticky_posts' => true,
			'fields'              => 'ids',
			'no_found_rows'       => true,
		)
	);

	if ( $cats && $same_category->have_posts() ) {
		$query['taxQuery'] = array( 'include' => array( 'category' => array_map( 'intval', $cats ) ) );
	} else {
		$any = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => 1,
				'post__not_in'        => array( $post_id ),
				'ignore_sticky_posts' => true,
				'fields'              => 'ids',
				'no_found_rows'       => true,
			)
		);

		if ( ! $any->have_posts() ) {
			return '';
		}
	}

	return bwe_blog_query_markup( $query, 'bwe-posts bwe-posts--related', false, 3 );
}

/**
 * One comment, as a card. Used by wp_list_comments() in templates/comments.php.
 *
 * @param WP_Comment $comment Comment.
 * @param array      $args    wp_list_comments() arguments.
 * @param int        $depth   Nesting depth.
 */
function bwe_blog_comment( $comment, $args, $depth ) {
	$is_author = $comment->user_id && (int) get_post_field( 'post_author', $comment->comment_post_ID ) === (int) $comment->user_id;
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( array( 'bwe-comment', $is_author ? 'bwe-comment--author' : '' ), $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="bwe-comment__card">
			<header class="bwe-comment__head">
				<?php echo get_avatar( $comment, 44, '', '', array( 'class' => 'bwe-comment__avatar' ) ); ?>
				<p class="bwe-comment__who">
					<span class="bwe-comment__name"><?php comment_author_link( $comment ); ?></span>
					<?php if ( $is_author ) : ?>
						<span class="bwe-comment__badge"><?php esc_html_e( 'Author', 'bestwebexpert-home' ); ?></span>
					<?php endif; ?>
					<a class="bwe-comment__time" href="<?php echo esc_url( get_comment_link( $comment ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
							/* translators: %s: time ago, e.g. "3 days". */
							printf( esc_html__( '%s ago', 'bestwebexpert-home' ), esc_html( human_time_diff( (int) get_comment_time( 'U', true ), time() ) ) );
							?>
						</time>
					</a>
				</p>
			</header>

			<?php if ( '0' === $comment->comment_approved ) : ?>
				<p class="bwe-comment__pending"><?php esc_html_e( 'Your comment is awaiting moderation.', 'bestwebexpert-home' ); ?></p>
			<?php endif; ?>

			<div class="bwe-comment__body"><?php comment_text(); ?></div>

			<footer class="bwe-comment__actions">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below'  => 'div-comment',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'reply_text' => __( 'Reply', 'bestwebexpert-home' ),
						)
					)
				);
				edit_comment_link( __( 'Edit', 'bestwebexpert-home' ) );
				?>
			</footer>
		</article>
	<?php
	// wp_list_comments() closes the <li>.
}
