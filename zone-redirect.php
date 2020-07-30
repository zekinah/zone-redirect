<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/zekinah
 * @since             1.0.0
 * @package           Zone_Redirect
 *
 * @wordpress-plugin
 * Plugin Name:       Zone - Redirect
 * Plugin URI:        https://github.com/zekinah/Zone-Redirect
 * Description:       This plugin helps you manage and create 301 & 302 redirects for your WordPress site to improve SEO and visitor experience. With a user-friendly interface, Zone Redirect is easy to install and configure.
 * Version:           1.0.5
 * Author:            Zekinah Lecaros
 * Author URI:        https://github.com/zekinah
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       zone-redirect
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ZONE_REDIRECT_VERSION', '1.0.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-zone-redirect-activator.php
 */
function activate_zone_redirect() {
	require_once plugin_dir_path( __FILE__ ) . 'model/Config.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-zone-redirect-activator.php';
	Zone_Redirect_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-zone-redirect-deactivator.php
 */
function deactivate_zone_redirect() {
	require_once plugin_dir_path( __FILE__ ) . 'model/Config.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-zone-redirect-deactivator.php';
	Zone_Redirect_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_zone_redirect' );
register_deactivation_hook( __FILE__, 'deactivate_zone_redirect' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-zone-redirect.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_zone_redirect() {

	$plugin = new Zone_Redirect();
	$plugin->run();

}
run_zone_redirect();
