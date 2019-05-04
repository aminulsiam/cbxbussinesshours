<?php

/**
 *
 * @link              https://codeboxr.com
 * @since             1.0.0
 * @package           CBXBusinessHours
 *
 * @wordpress-plugin
 * Plugin Name:       CBX Office Opening & Business Hours
 * Plugin URI:        https://codeboxr.com
 * Description:       Office opening and close time or business hours display
 * Version:           1.0.0
 * Author:            Codeboxr
 * Author URI:        https://codeboxr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cbxbusinesshours
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}


defined('CBXBUSINESSHOURS_PLUGIN_NAME') or define('CBXBUSINESSHOURS_PLUGIN_NAME', 'cbxbusinesshours');
defined('CBXBUSINESSHOURS_PLUGIN_VERSION') or define('CBXBUSINESSHOURS_PLUGIN_VERSION', '1.0.0');
defined('CBXBUSINESSHOURS_BASE_NAME') or define('CBXBUSINESSHOURS_BASE_NAME', plugin_basename(__FILE__));
defined('CBXBUSINESSHOURS_ROOT_PATH') or define('CBXBUSINESSHOURS_ROOT_PATH', plugin_dir_path(__FILE__));
defined('CBXBUSINESSHOURS_ROOT_URL') or define('CBXBUSINESSHOURS_ROOT_URL', plugin_dir_url(__FILE__));


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cbxbusinesshours-activator.php
 */
function activate_cbxbusinesshours()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-cbxbusinesshours-activator.php';
    CBXBusinessHours_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cbxbusinesshours-deactivator.php
 */
function deactivate_cbxbusinesshours()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-cbxbusinesshours-deactivator.php';
    CBXBusinessHours_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_cbxbusinesshours');
register_deactivation_hook(__FILE__, 'deactivate_cbxbusinesshours');
//register_uninstall_hook(__FILE__, 'uninstall_cbxbusinesshours');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-cbxbusinesshours.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cbxbusinesshours()
{
    $plugin = new CBXBusinessHours();
    $plugin->run();
}

run_cbxbusinesshours();
