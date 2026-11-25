<?php
/**
 * Posts page and post archives: the Blog page's block content inside Astra's header and footer.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="primary" class="content-area primary">
	<main id="main" class="site-main">
		<?php echo do_blocks( bwe_blog_archive_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Rendered block markup. ?>
	</main>
</div>
<?php
get_footer();
