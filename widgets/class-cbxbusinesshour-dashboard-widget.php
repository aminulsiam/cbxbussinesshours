<?php

class CBXBusinessHoursDashboard
{
    public function __construct()
    {

    }

    public function CBXBusinessHours_dashboard_widget()
    {
        $widget_option = get_option('cbxbusinesshours_dashboard_widget');
        if (!is_array($widget_option)) $widget_option = array();

        $role = isset($widget_option['role']) ? $widget_option['role'] : array('administrator');
        $user = wp_get_current_user();
        $result = array_intersect($role, $user->roles);
        if (sizeof($result) > 0) {
            wp_add_dashboard_widget(
                'cbxbusinesshours_dashboard_widget',
                esc_html__('CBX Office Opening & Business Hours', 'cbxbusinesshours'),
                array($this, 'CBXBusinessHours_widget_data'),
                array($this, 'CBXBusinessHours_widget_configure')
            );
        }
    }// end of CBXBusinessHours_dashboard_widget

    /**
     *
     */

    public function CBXBusinessHours_widget_data()
    {

        $data = get_option('cbxbusinesshours_settings');
        echo CBXBusinessHoursHelper::business_hours_display($data);

    }//end of CBXBusinessHours_widget_data method

    /**
     *
     */

    public function CBXBusinessHours_widget_configure()
    {
        $options = get_option('cbxbusinesshours_dashboard_widget');

        if (!is_array($options)) $options = array();

        if (isset($_POST['submit'])) {

            if (isset($_POST['role'])) {
                $role = $_POST['role'];
                $options['role'] = $role;
            } else {
                $role = array('administrator');
            }

            $options['role'] = array_merge(array('administrator'), $role);
            update_option('cbxbusinesshours_dashboard_widget', $options);
        } else {
            $role = isset($options['role']) ? $options['role'] : array('administrator');
        }
        ?>

        <h2><?php esc_html__('Following users can watch the schedule', 'cbxbusinesshours') ?></h2>

        <select id="" class="" name="role[]" multiple>
            <?php

            foreach (get_editable_roles() as $role_name => $role_info) {
                ?>
                <option <?php echo in_array($role_name, $role) ? ' selected' : ''; ?>
                        value="<?php echo $role_name; ?>"><?php echo esc_html__($role_info['name'], 'cbxbusinesshours'); ?></option>
            <?php } ?>
        </select>

        <?php
    }// end of CBXBusinessHours_widget_configure method
}