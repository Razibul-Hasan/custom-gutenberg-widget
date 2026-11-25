<?php
/**
 * MigrateLift landing page (/migrate-lift/, the plugin's Plugin URI): logo image, styles and schema.
 *
 * The page is built from patterns/migrate-lift.php and carries the bwe-ml class.
 *
 * @package BestWebExpert_Home
 */

defined( 'ABSPATH' ) || exit;


/**
 * Prints the tiny tab script for the screenshot tour (inline, so no optimizer can combine or mangle it).
 */
function bwe_ml_tour_script() {
	if ( ! bwe_home_is_needed( 'bwe-ml-tour' ) ) {
		return;
	}
	$js = <<<'JS'
document.querySelectorAll('.bwe-ml-tour').forEach(function (tour) {
	var img = tour.querySelector('.bwe-ml-tour__img'), url = tour.querySelector('.bwe-ml-tour__url b'), full = tour.querySelector('.bwe-ml-tour__full');
	var tabs = tour.querySelectorAll('.bwe-ml-tour__tab');
	tour.classList.add('is-js');
	tabs.forEach(function (tab, i) {
		tab.addEventListener('click', function () {
			tabs.forEach(function (t) { t.setAttribute('aria-pressed', t === tab ? 'true' : 'false'); });
			var row = tab.parentNode.parentNode;
			if (row.scrollWidth > row.clientWidth) { row.scrollTo({ left: tab.parentNode.offsetLeft - row.offsetLeft - 16, behavior: 'smooth' }); }
			img.classList.add('is-swapping');
			var next = new Image();
			next.onload = next.onerror = function () {
				img.srcset = tab.dataset.srcset; img.src = tab.dataset.src; img.alt = tab.dataset.alt;
				url.textContent = tab.dataset.path; full.href = tab.dataset.full;
				img.classList.remove('is-swapping');
			};
			next.sizes = img.sizes; next.srcset = tab.dataset.srcset; next.src = tab.dataset.src;
		});
		tab.addEventListener('keydown', function (e) {
			var d = { ArrowDown: 1, ArrowRight: 1, ArrowUp: -1, ArrowLeft: -1 }[e.key];
			if (!d) { return; }
			e.preventDefault();
			var t = tabs[(i + d + tabs.length) % tabs.length]; t.focus(); t.click();
		});
	});
});
JS;
	wp_print_inline_script_tag( $js, array( 'id' => 'bwe-ml-tour-js' ) );
}
add_action( 'wp_footer', 'bwe_ml_tour_script', 30 );

/**
 * Keeps SiteGround Optimizer from moving the tour script into its combined file (its minifier has broken plugin JS live).
 *
 * @param array $excluded Substrings of inline scripts SG must leave alone.
 * @return array
 */
function bwe_ml_tour_sg_exclude( $excluded ) {
	$excluded[] = '.bwe-ml-tour';
	return $excluded;
}
add_filter( 'sgo_javascript_combine_excluded_inline_content', 'bwe_ml_tour_sg_exclude' );

/**
 * Loads assets/migrate-lift.css on the landing page and in the editor.
 */
function bwe_ml_enqueue_assets() {
	if ( ! is_admin() && ! bwe_home_is_needed( 'bwe-ml' ) ) {
		return;
	}

	wp_enqueue_style(
		'bwe-ml',
		plugins_url( 'assets/migrate-lift.css', BWE_HOME_DIR . '/site.php' ),
		array( 'bwe-services' ),
		(string) filemtime( BWE_HOME_DIR . '/assets/migrate-lift.css' )
	);
}
add_action( 'enqueue_block_assets', 'bwe_ml_enqueue_assets', 20 );

/**
 * Adds SoftwareApplication and FAQPage schema to the MigrateLift page.
 *
 * @param array $data JSON-LD graph Rank Math prints.
 * @return array
 */
function bwe_ml_json_ld( $data ) {
	if ( ! bwe_home_is_needed( 'bwe-ml' ) ) {
		return $data;
	}

	$url = get_permalink( get_queried_object_id() );

	$faq = bwe_bwe_details_faq( bwe_post_content_expanded( get_queried_object_id() ) );
	if ( $faq ) {
		$faq['@id']     = $url . '#faq';
		$data['bweFaq'] = $faq;
	}

	$app = array(
		'@type'               => 'SoftwareApplication',
		'@id'                 => $url . '#software',
		'name'                => 'MigrateLift – Migration, Backup & Restore',
		'alternateName'       => 'MigrateLift',
		'description'         => 'Free WordPress migration, backup and restore plugin. Exports the database and wp-content into one .tgz or .zip archive, migrates to a new host or domain with serialization-safe URL replacement, transfers directly site to site over HTTPS and runs scheduled daily backups.',
		'url'                 => $url,
		'applicationCategory' => 'UtilitiesApplication',
		'operatingSystem'     => 'WordPress 6.6 or later, PHP 7.4 or later',
		'softwareVersion'     => '1.0.0',
		'license'             => 'https://www.gnu.org/licenses/gpl-2.0.html',
		'downloadUrl'         => 'https://wordpress.org/plugins/migrate-lift/',
		'featureList'         => array(
			'WordPress site migration to a new host or domain',
			'Database and wp-content backup in one .tgz or .zip archive',
			'Import and restore with preflight checks',
			'Direct site-to-site migration over HTTPS',
			'Automatic serialization-safe URL replacement',
			'Scheduled daily backups with rolling retention',
			'Chunked, resumable archive uploads',
		),
		'offers'              => array(
			'@type'         => 'Offer',
			'price'         => '0',
			'priceCurrency' => 'USD',
		),
		'author'              => array(
			'@type' => 'Organization',
			'name'  => 'BestWebExpert',
			'url'   => home_url( '/' ),
		),
	);

	$logo = (int) get_option( 'bwe_ml_logo' );
	if ( $logo ) {
		$app['image'] = wp_get_attachment_image_url( $logo, 'full' );
	}

	$shots = array_filter( array_map( 'wp_get_attachment_url', array_map( 'intval', (array) get_option( 'bwe_ml_shots', array() ) ) ) );
	if ( $shots ) {
		$app['screenshot'] = array_values( $shots );
	}

	$data['bweMigrateLift'] = $app;

	return $data;
}
add_filter( 'rank_math/json_ld', 'bwe_ml_json_ld', 98 );
