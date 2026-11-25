<?php
/**
 * Compares two snapshots made by snapshot-front.php.
 * Usage: php compare-front.php <dir-a> <dir-b>   (exit 1 on any difference)
 *
 * @package BWE_Gutenberg_Widget
 */

if ( PHP_SAPI !== 'cli' ) {
	exit;
}
[ , $a, $b ] = $argv + array( null, null, null );
$bad         = 0;
foreach ( glob( "$a/*.html" ) as $fa ) {
	$id = basename( $fa, '.html' );
	$fb = "$b/$id.html";
	if ( str_ends_with( $id, '.head' ) && ! is_file( $fb ) ) {
		continue; // <head> fingerprints are compared only when both snapshots have them (older ones do not).
	}
	if ( ! is_file( $fb ) ) {
		echo "$id MISSING in $b\n";
		++$bad;
		continue;
	}
	$x = file_get_contents( $fa );
	$y = file_get_contents( $fb );
	if ( $x === $y ) {
		echo "$id IDENTICAL\n";
		continue;
	}
	++$bad;
	$n = min( strlen( $x ), strlen( $y ) );
	$i = 0;
	while ( $i < $n && $x[ $i ] === $y[ $i ] ) {
		++$i;
	}
	echo "$id DIFF @$i: " . substr( $x, max( 0, $i - 20 ), 80 ) . ' | ' . substr( $y, max( 0, $i - 20 ), 80 ) . "\n";
}
echo $bad ? "RESULT: $bad page(s) differ\n" : "RESULT: all identical\n";
exit( $bad ? 1 : 0 );
