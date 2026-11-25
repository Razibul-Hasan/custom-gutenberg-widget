<?php
// Captures the CURRENT generator output (before it is changed) as the fixture for test_section_library_<name>.
require $argv[2] . '/lib.php';
bwe_tb_boot( $argv[1] );
$name = $argv[3];
$sample = require $argv[2] . "/tests/fixtures/sl-$name-sample.php";
$fn = 'bwe_sl_' . $name;
file_put_contents( $argv[2] . "/tests/fixtures/sl-$name.html", bwe_tb_render( $fn( $sample ) ) );
echo "sl-$name.html: " . filesize( $argv[2] . "/tests/fixtures/sl-$name.html" ) . " bytes\n";
