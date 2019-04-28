<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       aminulhossain.com
 * @since      1.0.0
 *
 * @package    Cbx_opening_hours
 * @subpackage Cbx_opening_hours/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cbx_opening_hours
 * @subpackage Cbx_opening_hours/includes
 * @author     Aminul haq siam <aminulhossain90@gmail.com>
 */
class Cbx_opening_hours_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cbx_opening_hours',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
