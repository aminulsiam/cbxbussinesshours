<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * CBX Office Opening & Business Hours Elementor Widget
 */
class CBXBusinessHours_ElemWidget extends Widget_Base {

	/**
	 * Retrieve widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'cbxbusinesshours';
	}

	/**
	 * Retrieve  widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'CBX Business Hours', 'cbxbusinesshours' );
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the widget categories.
	 *
	 * @since 1.0.10
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	/*public function get_categories() {
		return array('general');
	}*/

	/**
	 * Retrieve widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'cbxbusinesshours-icon';
	}

	/**
	 * Register google maps widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_cbxbusinesshours',
			array(
				'label' => esc_html__( 'CBX Business Hours', 'cbxbusinesshours' ),
			)
		);


		$this->add_control(
			'cbxbusinesshours_compact',
			array(
				'label'       => esc_html__( 'Display Mode', 'cbxbusinesshours' ),
				'type'        => Controls_Manager::SELECT2,
				'placeholder' => esc_html__( '', 'cbxbusinesshours' ),
				'default'     => 0,
				'options'     => array(
					0 => esc_html__( 'Plain Table', 'cbxbusinesshours' ),
					1 => esc_html__( 'Compact Table', 'cbxbusinesshours' )
				)
			)
		);

		$this->add_control(
			'cbxbusinesshours_time_format',
			array(
				'label'       => esc_html__( 'Time Format', 'cbxbusinesshours' ),
				'type'        => Controls_Manager::SELECT2,
				'placeholder' => esc_html__( '', 'cbxbusinesshours' ),
				'default'     => 24,
				'options'     => array(
					24 => esc_html__( '24 hours', 'cbxbusinesshours' ),
					12 => esc_html__( '12 hours', 'cbxbusinesshours' )
				)
			)
		);

		$this->add_control(
			'cbxbusinesshours_day_format',
			array(
				'label'       => esc_html__( 'Day Name Format', 'cbxbusinesshours' ),
				'type'        => Controls_Manager::SELECT2,
				'placeholder' => esc_html__( '', 'cbxbusinesshours' ),
				'default'     => 'long',
				'options'     => array(
					'long'  => esc_html__( 'Long', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Short', 'cbxbusinesshours' )
				)
			)
		);

		$this->add_control(
			'cbxbusinesshours_today',
			array(
				'label'       => esc_html__( 'Opening Days Display', 'cbxbusinesshours' ),
				'type'        => Controls_Manager::SELECT2,
				'placeholder' => esc_html__( '', 'cbxbusinesshours' ),
				'default'     => 'week',
				'options'     => array(
					'week'  => esc_html__( 'Current Week(7 days)', 'cbxbusinesshours' ),
					'today' => esc_html__( 'Today/For Current Date', 'cbxbusinesshours' )
				)
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render google maps widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		/*if ( !class_exists( 'CBXBusinessHoursSettings' ) ) {
			require_once CBXBUSINESSHOURS_ROOT_PATH . 'includes/class-cbxbusinesshours-settings.php';
		}

		$settings_api = new \CBXBusinessHoursSettings();*/
		$settings = $this->get_settings();


		$atts = array();

		$atts['compact']     = isset( $settings['cbxbusinesshours_compact'] ) ? intval( $settings['cbxbusinesshours_compact'] ) : 0;
		$atts['time_format'] = isset( $settings['cbxbusinesshours_time_format'] ) ? intval( $settings['cbxbusinesshours_time_format'] ) : 24;
		$atts['day_format']  = isset( $settings['cbxbusinesshours_day_format'] ) ? esc_attr( $settings['cbxbusinesshours_day_format'] ) : 'long';
		$atts['today']       = isset( $settings['cbxbusinesshours_today'] ) ? esc_attr( $settings['cbxbusinesshours_today'] ) : '';

		if ( $atts['today'] == 'week' ) {
			$atts['today'] = '';
		}

		echo \CBXBusinessHoursHelper::business_hours_display( $atts );
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function _content_template() {
	}
}//end method CBXBusinessHours_ElemWidget
