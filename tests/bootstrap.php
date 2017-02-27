<?php
/**
 * PHPUnit bootstrap file
 *
 * @package User_Login_Notifier
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
    require dirname( dirname( __FILE__ ) ) . '/user-login-notifier.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

global $current_user;
$current_user = new WP_User(1);
$current_user->user_login = 'collins';
$current_user->user_email = 'collins@wordpress.org';
$current_user->first_name = 'Admin';
$current_user->last_name = 'User';
$current_user->set_role('administrator');
wp_set_current_user(1);