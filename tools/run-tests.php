<?php
/**
 * Tiny test runner: loads tests/*.php and runs every function named test_*.
 * Usage: php run-tests.php <wp-root> [filter]   (filter = substring of the test file name)
 *
 * @package BWE_Gutenberg_Widget
 */

require __DIR__ . '/lib.php';
[ , $wp_root, $filter ] = $argv + array( null, null, '' );
bwe_tb_boot( $wp_root );

$before = get_defined_functions()['user'];
foreach ( glob( __DIR__ . '/tests/test-*.php' ) as $file ) {
	if ( '' === $filter || false !== strpos( basename( $file ), $filter ) ) {
		require_once $file;
	}
}
$tests = array_filter( array_diff( get_defined_functions()['user'], $before ), static fn( $f ) => 0 === strpos( $f, 'test_' ) );
foreach ( $tests as $test ) {
	echo "$test\n";
	try {
		$test();
	} catch ( Throwable $e ) {
		++$GLOBALS['bwe_tb_results']['fail'];
		echo '  FAIL threw ' . get_class( $e ) . ': ' . $e->getMessage() . "\n";
	}
}
printf( "PASS %d / FAIL %d\n", $GLOBALS['bwe_tb_results']['pass'], $GLOBALS['bwe_tb_results']['fail'] );
exit( $GLOBALS['bwe_tb_results']['fail'] ? 1 : 0 );
