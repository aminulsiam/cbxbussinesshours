<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              aminulhossain.com
 * @since             1.0.0
 * @package           Cbx_opening_hours
 *
 * @wordpress-plugin
 * Plugin Name:       cbx_opening_hours
 * Plugin URI:        cbxopeninghours.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Aminul haq siam
 * Author URI:        aminulhossain.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbx_opening_hours
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
define( 'CBX_OPENING_HOURS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cbx_opening_hours-activator.php
 */
function activate_cbx_opening_hours() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbx_opening_hours-activator.php';
	Cbx_opening_hours_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cbx_opening_hours-deactivator.php
 */
function deactivate_cbx_opening_hours() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cbx_opening_hours-deactivator.php';
	Cbx_opening_hours_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cbx_opening_hours' );
register_deactivation_hook( __FILE__, 'deactivate_cbx_opening_hours' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cbx_opening_hours.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cbx_opening_hours() {

	$plugin = new Cbx_opening_hours();
	$plugin->run();

}
run_cbx_opening_hours();
