<?php

/**
 * Plugin Name: User Login Notifier
 * Plugin URI: https://w3guy.com
 * Description: Notifies users by email each time a successful login happens with their account.
 * Version: 1.0
 * Author: Collins Agbonghama
 * Author URI: https://w3guy.com
 *
 */

namespace SitepointApp;

require 'vendor/autoload.php';

User_Login_Notifier::get_instance();