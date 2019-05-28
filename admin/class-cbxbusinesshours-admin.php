<?php

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * @link       https://codeboxr.com
	 * @since      1.0.0
	 *
	 * @package    CBXBusinessHours
	 * @subpackage CBXBusinessHours/admin
	 */

	/**
	 * The admin-specific functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    CBXBusinessHours
	 * @subpackage CBXBusinessHours/admin
	 * @author     Codeboxr <info@codeboxr.com>
	 */
	class CbxBusinessHours_Admin {

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
		 * @param      string $plugin_name The name of this plugin.
		 * @param      string $version     The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;

			//get plugin base file name
			$this->plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $plugin_name . '.php' );

			$this->setting = new CBXBusinessHoursSettings();
		}

		public function settings_init() {
			$this->setting->set_sections( $this->get_settings_sections() );
			$this->setting->set_fields( $this->get_settings_field() );
			$this->setting->admin_init();

		}// end of settings_init method

		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {
			$page   = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_style( 'cbxbusinesshours-admin', plugin_dir_url( __FILE__ ) . '../assets/css/cbxbusinesshours-admin.css', array(), $this->version, 'all' );

			if ( $page == 'cbxbusinesshours' ) {
				wp_register_style( 'select2', plugin_dir_url( __FILE__ ) . '../assets/select2/css/select2.min.css', array(), $this->version );

				wp_register_style( 'jquery-timepicker', plugin_dir_url( __FILE__ ) . '../assets/css/jquery.timepicker.min.css', array(), $this->version, 'all' );
				wp_register_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . '../assets/css/jquery-ui.css', array(), $this->version, 'all' );
				wp_register_style( 'cbxbusinesshours-settings', plugin_dir_url( __FILE__ ) . '../assets/css/cbxbusinesshours-settings.css', array(
					'select2',
					'jquery-timepicker',
					'jquery-ui',
					'wp-color-picker'
				), $this->version, 'all' );

				wp_enqueue_style( 'select2' );
				wp_enqueue_style( 'jquery-timepicker' );
				wp_enqueue_style( 'jquery-ui' );
				wp_enqueue_style( 'wp-color-picker' );

				wp_enqueue_style( 'cbxbusinesshours-settings' );
			}
		}//end method enqueue_styles

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {
			$page           = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
			$current_screen = get_current_screen();


			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';


			if ( $page == 'cbxbusinesshours' ) {


				wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . '../assets/select2/js/select2.min.js', array( 'jquery' ), $this->version, true );
				wp_register_script( 'jquery-timepicker', plugin_dir_url( __FILE__ ) . '../assets/js/jquery.timepicker.min.js', array( 'jquery' ), $this->version, true );
				wp_register_script( 'cbxbusinesshours-settings', plugin_dir_url( __FILE__ ) . '../assets/js/cbxbusinesshours-settings.js', array(
					'jquery',
					'select2',
					'jquery-timepicker',
					'jquery-ui-datepicker',
					'wp-color-picker'
				), $this->version, true );


				// Localize the script with translation
				$translation_placeholder = apply_filters( 'cbxbusinesshours_setting_js_vars', array(
					'remove'  => esc_html__( 'Remove', 'cbxbusinesshours' ),
					'date'    => esc_html__( 'Date', 'cbxbusinesshours' ),
					'start'   => esc_html__( 'Start', 'cbxbusinesshours' ),
					'end'     => esc_html__( 'End', 'cbxbusinesshours' ),
					'subject' => esc_html__( 'Subject', 'cbxbusinesshours' ),
					//'hoursformat' => $hoursformat
				) );

				wp_localize_script( 'cbxbusinesshours-settings', 'cbxbusinesshours_setting', $translation_placeholder );


				wp_enqueue_script( 'jquery' );
				wp_enqueue_media();
				wp_enqueue_script( 'select2' );
				wp_enqueue_script( 'jquery-timepicker' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script( 'cbxbusinesshours-settings' );
			}

			if ( ( isset( $current_screen->id ) && $current_screen->id == 'widgets' ) || ( isset( $_REQUEST['edit'] ) && $_REQUEST['edit'] == 'cbxbusinesshours_dashboard_widget' ) ) {
				wp_register_script( 'cbxbusinesshours-widgets', plugin_dir_url( __FILE__ ) . '../assets/js/cbxbusinesshours-widgets.js', array(
					'jquery',
					'jquery-ui-datepicker'
				), $this->version, true );

				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'cbxbusinesshours-widgets' );

				wp_register_style( 'jquery-ui', plugin_dir_url( __FILE__ ) . '../assets/css/jquery-ui.css', array(), $this->version, 'all' );
				wp_enqueue_style( 'jquery-ui' );
			}
		}//end method enqueue_scripts

		/**
		 * This admin_menu method will create options page
		 */
		public function admin_menu() {
			add_options_page( esc_html__( 'Office Opening & Business Hours', 'cbxbusinesshours' ), esc_html__( 'Office Business Hours', 'cbxbusinesshours' ), 'manage_options', 'cbxbusinesshours', array(
				$this,
				'display_plugin_admin_settings'
			) );
		}// end of admin_menu method

		/**
		 * This callback method
		 */
		public function display_plugin_admin_settings() {

			global $wpdb;

			$plugin_data = get_plugin_data( plugin_dir_path( __DIR__ ) . '/../' . $this->plugin_basename );

			include( cbxbusinesshours_locate_template( 'admin/setting.php' ) );
		}// end of CBXBusinessHours_options_page_data method

		public function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'cbxbusinesshours_hours',
					'title' => esc_html__( 'Manage Hours', 'cbxbusinesshours' )
				),
				array(
					'id'    => 'cbxbusinesshours_settings',
					'title' => esc_html__( 'Settings', 'cbxbusinesshours' )
				)
			);

			return apply_filters( 'cbxbusinesshours_setting_sections', $sections );
		}// end of get_settings_sections method

		public function get_settings_field() {

			$weekdays_default  = array(
				'sunday' => array(
					'start' => '',
					'end'   => ''
				),

				'monday' => array
				(
					'start' => '',
					'end'   => ''
				),

				'tuesday' => array
				(
					'start' => '',
					'end'   => '',
				),

				'wednesday' => array
				(
					'start' => '',
					'end'   => ''
				),

				'thursday' => array
				(
					'start' => '',
					'end'   => ''
				),

				'friday' => array
				(
					'start' => '',
					'end'   => ''
				),

				'saturday' => array
				(
					'start' => '',
					'end'   => ''
				)
			);

			$settings_builtin_fields = array(
				'cbxbusinesshours_hours'    => array(
					array(
						'name'  => 'weekdays',
						'label' => esc_html__( 'Week Days', 'cbxbusinesshours' ),
						'type'  => 'weekdays',
						'default' => $weekdays_default
					),
					array(
						'name'              => 'dayexception',
						'label'             => esc_html__( 'Exception Days / Holiday', 'cbxbusinesshours' ),
						'type'              => 'dayexception',
						'sanitize_callback' => array( 'CBXBusinessHoursHelper', 'sanitize_callback_dayexception' )
					)

				),
				'cbxbusinesshours_settings' => array(
					array(
						'name'    => 'compact',
						'label'   => esc_html__( 'Default Display Mode', 'cbxbusinesshours' ),
						'type'    => 'select',
						'options' => array(
							0 => esc_html__( 'Normal', 'cbxbusinesshours' ),
							1 => esc_html__( 'Compact', 'cbxbusinesshours' )
						),
						'default' => 0
					),
					array(
						'name'    => 'time_format',
						'label'   => esc_html__( 'Time Format', 'cbxbusinesshours' ),
						'type'    => 'select',
						'options' => array(
							'24' => esc_html__( '24 Hour', 'cbxbusinesshours' ),
							'12' => esc_html__( '12 Hour', 'cbxbusinesshours' )
						),
						'default' => 24
					),
					array(
						'name'    => 'day_format',
						'label'   => esc_html__( 'Day Name Format', 'cbxbusinesshours' ),
						'type'    => 'select',
						'options' => array(
							'long'  => esc_html__( 'Long Name(Example: Sunday)', 'cbxbusinesshours' ),
							'short' => esc_html__( 'Short Name(Example: Sun)', 'cbxbusinesshours' )
						),
						'default' => 'long'
					),
					array(
						'name'    => 'today',
						'label'   => esc_html__( 'Opening Days Display', 'cbxbusinesshours' ),
						'type'    => 'select',
						'options' => array(
							''      => esc_html__( 'Current Week(7 days)', 'cbxbusinesshours' ),
							'today' => esc_html__( 'Today/For Current Date', 'cbxbusinesshours' )
						),
						'default' => ''
					),
				)
			);

			$settings_fields = array(); //final setting array that will be passed to different filters

			$sections = $this->get_settings_sections();


			foreach ( $sections as $section ) {
				if ( ! isset( $settings_builtin_fields[ $section['id'] ] ) ) {
					$settings_builtin_fields[ $section['id'] ] = array();
				}
			}

			foreach ( $sections as $section ) {
				$settings_fields[ $section['id'] ] = apply_filters( 'cbxbusinesshours_global_' . $section['id'] . '_fields',
					$settings_builtin_fields[ $section['id'] ] );
			}

			$settings_fields = apply_filters( 'cbxbusinesshours_global_fields', $settings_fields ); //final filter if need

			return $settings_fields;
		}//end method get_settings_field

		public function gutenberg_blocks_init(){
			//wp_register_style( 'cbxbusinesshours-public', plugin_dir_url( __FILE__ ) . '../assets/css/cbxbusinesshours-public.css', array(), $this->version, 'all' );

			wp_register_script('cbxbusinesshours-block',
				plugin_dir_url( __FILE__ ) . '../assets/js/cbxbusinesshours-block.js',
				array( 'wp-blocks', 'wp-i18n', 'wp-element' ), $this->version, true
			);

			register_block_type( 'codeboxsr/cbxbusinesshours', array(
				'editor_script' => 'cbxbusinesshours',
			) );

			wp_enqueue_script('cbxbusinesshours-block');
		}

	}//end class CbxBusinessHours_Admin
