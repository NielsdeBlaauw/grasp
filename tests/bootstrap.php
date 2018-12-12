<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Grasp
 */

$grasp_test_dir = getenv( 'WPgrasp_test_dir' );

if ( ! $grasp_test_dir ) {
	$grasp_test_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $grasp_test_dir . '/includes/functions.php' ) ) {
	echo "Could not find $grasp_test_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // WPCS: XSS ok.
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $grasp_test_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function grasp_manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/grasp.php';
}
tests_add_filter( 'muplugins_loaded', 'grasp_manually_load_plugin' );

// Start up the WP testing environment.
require $grasp_test_dir . '/includes/bootstrap.php';
