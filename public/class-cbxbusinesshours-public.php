<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codeboxr.com
 * @since      1.0.0
 *
 * @package    CBXBusinessHours
 * @subpackage CBXBusinessHours/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CBXBusinessHours
 * @subpackage CBXBusinessHours/public
 * @author     Codeboxr <info@codeboxr.com>
 */
class CBXBusinessHours_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;


	private $setting;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->setting = new CBXBusinessHoursSettings();
	}//end

	/**
	 *
	 */
	public function init_register_widgets() {
		register_widget( 'CBXBusinessHoursFrontWidget' );
	}// end of init_register_widgets method

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style( 'cbxbusinesshours-public', plugin_dir_url( __FILE__ ) . '../assets/css/cbxbusinesshours-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

	}//end method enqueue_scripts

	/**
	 * init all shortcodes
	 */
	public function init_shortcodes() {
		add_shortcode( 'cbxbusinesshours', array( $this, 'cbxbusinesshours_shortcode' ) );
	}//end method init_shortcodes

	/**
	 * @param array $atts
	 */
	public function cbxbusinesshours_shortcode( $atts ) {

		$setting = $this->setting;

		$compact = $setting->get_option( 'compact', 'cbxbusinesshours_settings', 0 );

		$atts = shortcode_atts( array(
			'compact'     => $compact,
			'time_format' => 24,
			'length'      => 'long',
			'today'       => ''

		), $atts );

		wp_enqueue_style( 'cbxbusinesshours-public' );

		return CBXBusinessHoursHelper::business_hours_display( $atts );
	}//end method cbxbusinesshours_shortcode
}
