<?php
/**
 * Single post: header and cover at the site's content width, then the post in a reading column
 * beside a sticky "On this page" sidebar, then related posts and comments.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

get_header();

$bwe_blog_page = (int) get_option( 'page_for_posts' );
$bwe_blog_url  = $bwe_blog_page ? get_permalink( $bwe_blog_page ) : home_url( '/' );
?>
<div id="primary" class="content-area primary">
	<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			$bwe_author_id = (int) get_the_author_meta( 'ID' );
			$bwe_bio       = get_the_author_meta( 'description' );
			$bwe_share_url = rawurlencode( get_permalink() );
			$bwe_share_txt = rawurlencode( get_the_title() );
			$bwe_related   = bwe_blog_related_markup( get_the_ID() );
			$bwe_cat       = current( wp_list_filter( get_the_category(), array( 'term_id' => 1 ), 'NOT' ) );
			$bwe_tags      = get_the_tags();
			$bwe_updated   = get_the_modified_date( 'Ymd' ) > get_the_date( 'Ymd' );
			$bwe_content   = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content() ) ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Core hook.
			$bwe_toc       = bwe_blog_toc_items( $bwe_content );
			?>
			<div class="bwe-home bwe-blog bwe-single">
				<div class="bwe-progress" aria-hidden="true"></div>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'bwe-article' ); ?>>
					<header class="bwe-article__head">
						<nav class="bwe-article__crumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'bestwebexpert-home' ); ?>">
							<a href="<?php echo esc_url( $bwe_blog_url ); ?>"><?php esc_html_e( 'Blog', 'bestwebexpert-home' ); ?></a>
							<?php if ( $bwe_cat ) : ?>
								<span aria-hidden="true">/</span>
								<a href="<?php echo esc_url( get_category_link( $bwe_cat ) ); ?>"><?php echo esc_html( $bwe_cat->name ); ?></a>
							<?php endif; ?>
						</nav>

						<?php the_title( '<h1 class="wp-block-heading bwe-article__title">', '</h1>' ); ?>

						<?php if ( has_excerpt() ) : ?>
							<p class="bwe-article__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>

						<p class="bwe-article__meta">
							<?php echo get_avatar( $bwe_author_id, 28, '', '', array( 'class' => 'bwe-article__avatar' ) ); ?>
							<a class="bwe-article__author" href="<?php echo esc_url( get_author_posts_url( $bwe_author_id ) ); ?>"><?php the_author(); ?></a>
							<?php if ( $bwe_updated ) : ?>
								<span>
									<?php
									/* translators: %s: date the post was last updated. */
									printf( esc_html__( 'Updated %s', 'bestwebexpert-home' ), '<time datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date() ) . '</time>' );
									?>
								</span>
							<?php else : ?>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php endif; ?>
							<span><?php echo esc_html( bwe_blog_reading_label() ); ?></span>
						</p>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="bwe-article__cover">
							<?php the_post_thumbnail( 'full', array( 'sizes' => '(max-width: 1200px) 100vw, 1200px' ) ); ?>
						</figure>
					<?php endif; ?>

					<div class="bwe-article__body<?php echo $bwe_toc ? ' has-toc' : ''; ?>">
						<div class="bwe-article__main">
							<div class="bwe-prose">
								<?php
								echo $bwe_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Filtered post content.

								wp_link_pages(
									array(
										'before' => '<nav class="bwe-pages">',
										'after'  => '</nav>',
									)
								);
								?>
							</div>

							<footer class="bwe-article__foot">
								<?php if ( $bwe_tags ) : ?>
									<ul class="bwe-article__tags">
										<?php foreach ( $bwe_tags as $bwe_tag ) : ?>
											<li><a href="<?php echo esc_url( get_tag_link( $bwe_tag ) ); ?>">#<?php echo esc_html( $bwe_tag->name ); ?></a></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>

								<div class="bwe-author">
									<?php echo get_avatar( $bwe_author_id, 56, '', '', array( 'class' => 'bwe-author__avatar' ) ); ?>
									<div class="bwe-author__text">
										<p class="bwe-author__name">
											<?php
											/* translators: %s: author name. */
											printf( esc_html__( 'Written by %s', 'bestwebexpert-home' ), esc_html( get_the_author() ? get_the_author() : __( 'the BestWebExpert team', 'bestwebexpert-home' ) ) );
											?>
										</p>
										<p class="bwe-author__bio"><?php echo esc_html( $bwe_bio ? $bwe_bio : __( 'Part of the BestWebExpert team: 7+ years designing and developing WordPress websites and Shopify stores.', 'bestwebexpert-home' ) ); ?></p>
									</div>
								</div>
							</footer>
						</div>

						<aside class="bwe-article__side" aria-label="<?php esc_attr_e( 'About this post', 'bestwebexpert-home' ); ?>">
							<div class="bwe-article__side-inner">
								<?php if ( $bwe_toc ) : ?>
									<nav class="bwe-toc" aria-labelledby="bwe-toc-title">
										<p id="bwe-toc-title" class="bwe-side__label"><?php esc_html_e( 'On this page', 'bestwebexpert-home' ); ?></p>
										<ol>
											<?php foreach ( $bwe_toc as $bwe_item ) : ?>
												<li><a href="#<?php echo esc_attr( $bwe_item['id'] ); ?>"><?php echo esc_html( $bwe_item['title'] ); ?></a></li>
											<?php endforeach; ?>
										</ol>
									</nav>
								<?php endif; ?>

								<div class="bwe-share">
									<p class="bwe-side__label"><?php esc_html_e( 'Share', 'bestwebexpert-home' ); ?></p>
									<p class="bwe-share__links">
										<a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $bwe_share_url . '&text=' . $bwe_share_txt ); ?>" target="_blank" rel="noopener noreferrer">X</a>
										<a href="<?php echo esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $bwe_share_url ); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
										<a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $bwe_share_url ); ?>" target="_blank" rel="noopener noreferrer">Facebook</a>
									</p>
								</div>

								<div class="bwe-article__cta">
									<p class="bwe-article__cta-title"><?php esc_html_e( 'Rather have us do it for you?', 'bestwebexpert-home' ); ?></p>
									<p><?php esc_html_e( 'Get a free website audit with 3 quick wins you can use today, even if you never hire us.', 'bestwebexpert-home' ); ?></p>
									<a class="bwe-article__cta-link" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Claim my free audit', 'bestwebexpert-home' ); ?></a>
								</div>
							</div>
						</aside>
					</div>
				</article>

				<?php if ( $bwe_related ) : ?>
					<section class="bwe-section bwe-related" aria-labelledby="bwe-related-title">
						<h2 id="bwe-related-title" class="wp-block-heading bwe-related__title"><?php esc_html_e( 'Keep reading', 'bestwebexpert-home' ); ?></h2>
						<?php echo do_blocks( $bwe_related ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered block markup. ?>
					</section>
				<?php endif; ?>

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>

			<?php if ( $bwe_toc ) : ?>
				<script>
				// Marks the section being read in the "On this page" list.
				( function () {
					var links = document.querySelectorAll( '.bwe-toc a' );
					if ( ! links.length || ! ( 'IntersectionObserver' in window ) ) {
						return;
					}
					var byId = {};
					links.forEach( function ( link ) {
						byId[ decodeURIComponent( link.hash.slice( 1 ) ) ] = link;
					} );
					var observer = new IntersectionObserver( function ( entries ) {
						entries.forEach( function ( entry ) {
							if ( entry.isIntersecting && byId[ entry.target.id ] ) {
								links.forEach( function ( link ) {
									link.removeAttribute( 'aria-current' );
								} );
								byId[ entry.target.id ].setAttribute( 'aria-current', 'location' );
							}
						} );
					}, { rootMargin: '0px 0px -70% 0px' } );
					Object.keys( byId ).forEach( function ( id ) {
						var heading = document.getElementById( id );
						if ( heading ) {
							observer.observe( heading );
						}
					} );
				} )();
				</script>
			<?php endif; ?>
			<?php
		endwhile;
		?>
	</main>
</div>
<?php
get_footer();
