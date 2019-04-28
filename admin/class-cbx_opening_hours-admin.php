<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       aminulhossain.com
 * @since      1.0.0
 *
 * @package    Cbx_opening_hours
 * @subpackage Cbx_opening_hours/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cbx_opening_hours
 * @subpackage Cbx_opening_hours/admin
 * @author     Aminul haq siam <aminulhossain90@gmail.com>
 */
class Cbx_opening_hours_Admin
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

    private $settings_api;

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

        $this->settings_api = new WeDevs_Settings_API();

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         *  Enqueue all styles
         */

        wp_enqueue_style('cbx_opening_hours_css', plugin_dir_url(__FILE__) . '../assets/css/cbx_opening_hours-admin.css', array(), time(), 'all');

        wp_enqueue_style('cbx_opening_hours_timepicker', plugin_dir_url(__FILE__) . '../assets/css/jquery.timepicker.min.css', array(), time(), 'all');

        wp_enqueue_style('cbx_opening_hours_chosen', plugin_dir_url(__FILE__) . '../assets/css/jquery.chosen.min.css', array(), time(), 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         *  Enqueue all scripts
         */

        wp_enqueue_script('cbx_opening_hours_js', plugin_dir_url(__FILE__) . '../assets/js/cbx_opening_hours-admin.js', array('jquery'), time(), true);

        wp_enqueue_script('cbx_opening_hours_js-timepicker', plugin_dir_url(__FILE__) . '../assets/js/jquery.timepicker.min.js', array('jquery'), time(), true);

        wp_enqueue_script('cbx_opening_hours_js-chosen', plugin_dir_url(__FILE__) . '../assets/js/chosen.jquery.min.js', array('jquery'), time(), true);

    }

    /**
     * Admin init for @settings_api
     */
    public function admin_init()
    {
        //set the settings
        $this->settings_api->set_sections($this->get_settings_sections());
        $this->settings_api->set_fields($this->get_settings_fields());

        //initialize settings
        $this->settings_api->admin_init();
    }


    /**
     * @return array
     *
     * Set all the sections
     *
     */
    function get_settings_sections()
    {
        $sections = array(
            array(
                'id' => 'cbx_opening_hours',
                'title' => __('Opening and Ending hours', 'cbx_opening_hours')
            ),
            array(
                'id' => 'cbx_opening_hours_settings',
                'title' => __('Settings', 'cbx_opening_hours')
            ),
        );
        return $sections;

    }


    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields()
    {
        $settings_fields = array(
            'cbx_opening_hours' => array(
                array(
                    'name' => 'sunday',
                    'label' => __('Sunday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'monday',
                    'label' => __('Monday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'tuesday',
                    'label' => __('Tuesday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'wednesday',
                    'label' => __('Wednesday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'thursday',
                    'label' => __('Thurday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'friday',
                    'label' => __('Friday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),
                array(
                    'name' => 'saturday',
                    'label' => __('Saturday', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'text'
                ),

            ),

            'cbx_opening_hours_settings' => array(
                array(
                    'name' => 'compact',
                    'label' => __('settings', 'cbx_opening_hours'),
                    'placeholder' => __('opening hours', 'cbx_opening_hours'),
                    'type' => 'select',
                    'options' => array(
                        '0' => 'Normal',
                        '1' => 'Compact'
                    )
                ),
            ),

        );

        return $settings_fields;
    } // end of get_settings_fields


    /**
     * Add opening hours page under @settings menu
     */
    public function cbx_openinghours()
    {
        add_options_page(
            _x('CBX Opening hours', 'cbx_opening_hours'),
            _x('Opening hours', 'cbx_opening_hours'),
            'manage_options',
            'opening_hours',
            array($this, "cbx_openinghours_field")
        );
    }

    /**
     * @DISPLAY opening hours field form
     *
     * @no_param
     */
    public function cbx_openinghours_field()
    {
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
    }


    /**
     * @Widget for cbx opening hours .
     */
    public function cbx_openinghour_widgets()
    {
        require_once plugin_dir_path(__FILE__) . "../widgets/cbx-openinghours-widget.php";

        register_widget('Opening_Hours_Widget');
    }


    /**
     * @Dashboard_widget
     *
     * Add dashboard widget to dashboard for showing opening hours details,
     *
     * Some specific @user_role
     */
    public function cbx_oh_dashboard_widget()
    {
        $widget_option = get_option('cbx_user_roles');

        if (!is_array($widget_option)) $widget_option = array();

        $role = isset($widget_option['cbx_user_roles']) ? $widget_option['cbx_user_roles'] : array('administrator');
        $user = wp_get_current_user();
        $result = array_intersect($role, $user->roles);

        if (sizeof($result) > 0) {
            wp_add_dashboard_widget(
                __('oh_dashboard_widget'),
                __('Opening and ending hours widget'),
                array($this, 'oh_dashboard_widget_callback'),
                array($this, 'cbx_oh_configure_role')
            );
        }

    } // end of method cbx_oh_dashboard_widget


    /**
     * @dashboard_configure callback
     */
    public function cbx_oh_configure_role()
    {
        $options = get_option('cbx_user_roles');

        if (!is_array($options)) $options = array();

        if (isset($_POST['submit'])) {
            if ($_POST['cbx_user_roles']) {

                $role = $_POST['cbx_user_roles'];

                if (!is_array($role)) $role = array('administrator');

                $options['cbx_user_roles'] = array_merge(array('administrator'), $role);

                update_option('cbx_user_roles', $options);
            } else {
                $role = array('administrator');
            }
        }
        ?>

        <label for="cbx_user_role"><?= esc_html__('Role : ', 'cbx_opening_hours'); ?></label>
        <select class="" name="cbx_user_roles[]" multiple>
            <?php
            foreach (get_editable_roles() as $role_name => $role_info) {
                $selected = "";

                if (in_array($role_name, $options['cbx_user_roles'])) {
                    $selected = "selected";
                }
                ?>
                <option value="<?= esc_attr($role_name); ?>" <?= esc_attr($selected); ?> >
                    <?= esc_html($role_info['name']); ?>
                </option>
            <?php } ?>
        </select>

        <?php
    } // End of method cbx_oh_configure_role

    /**
     * @callback for add dashboard widget
     */
    public function oh_dashboard_widget_callback()
    {

        $data = get_option('cbx_opening_hours_settings');
        echo CBXOpeningHours::business_hours_display($data);

    } // end of oh_dashboard_widget_callback


} // End of CBX_opening_hours_Admin
