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
class CbxBusinessHours_Admin
{

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
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->setting = new CBXBusinessHoursSettings();
    }

    public function settings_init()
    {
        $this->setting->set_sections($this->get_settings_sections());
        $this->setting->set_fields($this->get_settings_field());
        $this->setting->admin_init();

    }// end of settings_init method

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        $page = isset($_REQUEST['page']) ? sanitize_text_field($_REQUEST['page']) : '';

        if ($page == 'cbxbusinesshours') {

            wp_register_style('jquery-timepicker', plugin_dir_url(__FILE__) . '../assets/css/jquery.timepicker.min.css', array(), $this->version, 'all');

            wp_register_style('jquery-ui', plugin_dir_url(__FILE__) . '../assets/css/jquery-ui.css', array(), '1.12.1', 'all');

            wp_register_style('jquery-ui', plugin_dir_url(__FILE__) . '../assets/css/jquery-ui.css', array(), '1.6.3');

            wp_register_style('cbxbusinesshours-admin', plugin_dir_url(__FILE__) . '../assets/css/cbxbusinesshours-admin.css', array('jquery-timepicker'), $this->version, 'all');

            wp_enqueue_style('jquery-timepicker');
            wp_enqueue_style('jquery-ui');
            wp_enqueue_style('cbxbusinesshours-admin');
        }
    }//end method enqueue_styles

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        $page = isset($_REQUEST['page']) ? sanitize_text_field($_REQUEST['page']) : '';

        if ($page == 'cbxbusinesshours') {

            wp_register_script('jquery-timepicker', plugin_dir_url(__FILE__) . '../assets/js/jquery.timepicker.min.js', array('jquery'), time(), true);

            wp_register_script('jquery-ui', plugin_dir_url(__FILE__) . '../assets/js/jquery-ui.js', array('jquery'), '1.6.3', true);

            wp_register_script('cbxbusinesshours-admin', plugin_dir_url(__FILE__) . '../assets/js/cbxbusinesshours-admin.js', array('jquery', 'jquery-timepicker'), time(), true);


            // Localize the script with translation
            $translation_placeholder = array(
                'remove' => __( 'Remove', 'cbxbusinesshours' ),
                'date' => __( 'Date', 'cbxbusinesshours' ),
                'start' => __( 'Start', 'cbxbusinesshours' ),
                'end' => __( 'End', 'cbxbusinesshours' ),
                'subject' => __( 'Subject', 'cbxbusinesshours' )
            );
            wp_localize_script( 'cbxbusinesshours-admin', 'translation', $translation_placeholder );


            wp_enqueue_script('jquery-timepicker');
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('cbxbusinesshours-admin');
        }
    }//end method enqueue_scripts

    /**
     * This admin_menu method will create options page
     */
    public function admin_menu()
    {
        add_options_page(esc_html__('Office Opening & Business Hours', 'cbxbusinesshours'), esc_html__('Office Business Hours', 'cbxbusinesshours'), 'manage_options', 'cbxbusinesshours', array($this, 'CBXBusinessHours_options_page_data'));
    }// end of admin_menu method

    /**
     * This callback method
     */
    public function CBXBusinessHours_options_page_data()
    {
        echo '<div class="wrap">';
        $this->setting->show_navigation();
        $this->setting->show_forms();
        echo '</div>';
    }// end of CBXBusinessHours_options_page_data method

    public function get_settings_sections()
    {
        $sections = array(
            array(
                'id' => 'cbxbusinesshours_hours',
                'title' => esc_html__('Manage Hours', 'cbxbusinesshours')
            ),
            array(
                'id' => 'cbxbusinesshours_settings',
                'title' => esc_html__('Settings', 'cbxbusinesshours')
            )
        );
        return $sections;
    }// end of get_settings_sections method

    public function get_settings_field()
    {
        $settings_fields = array(
            'cbxbusinesshours_hours' => array(
                array(
                    'name' => 'weekdays',
                    'label' => esc_html__('Week Days', 'cbxbusinesshours'),
                    'type' => 'time3'
                ),
                array(
                    'name' => 'exceptions',
                    'label' => esc_html__('Exception Days / Holiday', 'cbxbusinesshours'),
                    'type' => 'exceptionDay'
                )

            ),
            'cbxbusinesshours_settings' => array(
                array(
                    'name' => 'compact',
                    'label' => esc_html__('Default Display Mode', 'cbxbusinesshours'),
                    'type' => 'select',
                    'options' => array(
                        0 => esc_html__('Normal', 'cbxbusinesshours'),
                        1 => esc_html__('Compact', 'cbxbusinesshours')
                    ),
                    'default' => 0
                )
            )
        );
        return $settings_fields;
    }//end method get_settings_field

}//end class CbxBusinessHours_Admin
