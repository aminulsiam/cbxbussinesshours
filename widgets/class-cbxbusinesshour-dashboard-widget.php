<?php
	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

class CBXBusinessHoursDashboard
{
    public function __construct()
    {
    	$this->setting = new CBXBusinessHoursSettings();

    }

    public function CBXBusinessHours_dashboard_widget()
    {
    	$widget_option = get_option('cbxbusinesshours_dashboard_widget');
        if (!is_array($widget_option)) $widget_option = array();

        $role = isset($widget_option['role']) ? $widget_option['role'] : array('administrator');
        $user = wp_get_current_user();
        $result = array_intersect($role, $user->roles);
        if (is_array($result) && sizeof($result) > 0) {
            wp_add_dashboard_widget(
                'cbxbusinesshours_dashboard_widget',
                esc_html__('CBX Office Opening & Business Hours', 'cbxbusinesshours'),
                array($this, 'widget_display'),
                array($this, 'widget_configure')
            );
        }
    }//end of CBXBusinessHours_dashboard_widget

    /**
     * Widget display
     */
    public function widget_display(){

	    $options = get_option('cbxbusinesshours_dashboard_widget');

	    $compact     = isset( $options['compact'] ) ? intval( $options['compact'] ) : 0;
	    $time_format = isset( $options['time_format'] ) ? intval( $options['time_format'] ) : 24;
	    $day_format  = isset( $options['day_format'] ) ? esc_attr($options['day_format']) : 'long';
	    $today       = isset( $options['today'] ) ? esc_attr($options['today']) : 'week';
	    $custom_date = isset( $options['custom_date'] ) ? $options['custom_date'] : '';

	    if($today == 'week') $today = '';

	    if($custom_date != '' && !CBXBusinessHoursHelper::validateDate( $custom_date)){
		    $custom_date = '';
	    }

	    if($today == 'today' && $custom_date != ''){
		    $today = $custom_date;
	    }

	    $args = array(
		    'compact'     => $compact,
		    'time_format' => $time_format,
		    'day_format'  => $day_format,
		    'today'       => $today
	    );

        echo CBXBusinessHoursHelper::business_hours_display($args);

    }//end of method widget_display

    /**
     * Configure form of widget
     */
    public function widget_configure()
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

	        $options['compact'] = isset($_POST['cbxbusinesshours_compact'])? intval($_POST['cbxbusinesshours_compact']) : 0;
	        $options['time_format'] = isset($_POST['cbxbusinesshours_time_format'])? intval($_POST['cbxbusinesshours_time_format']) : 24;
	        $options['day_format'] = isset($_POST['cbxbusinesshours_day_format'])? sanitize_text_field($_POST['cbxbusinesshours_day_format']) : 'long';
	        $options['today'] = isset($_POST['cbxbusinesshours_today'])? sanitize_text_field($_POST['cbxbusinesshours_today']) : 'week';
	        $custom_date = isset($_POST['cbxbusinesshours_custom_date'])? sanitize_text_field($_POST['cbxbusinesshours_custom_date']) : '';

	        if($custom_date != '' && !CBXBusinessHoursHelper::validateDate( $custom_date)){
		        $custom_date = '';
	        }

	        $options['custom_date'] = $custom_date;

            update_option('cbxbusinesshours_dashboard_widget', $options);
        }




	    $role 		 = isset($options['role']) ? $options['role'] : array('administrator');
	    $compact     = isset( $options['compact'] ) ? intval( $options['compact'] ) : 0;
	    $time_format = isset( $options['time_format'] ) ? intval( $options['time_format'] ) : 24;
	    $day_format  = isset( $options['day_format'] ) ? esc_attr($options['day_format']) : 'long';
	    $today       = isset( $options['today'] ) ? $options['today'] : 'week';
	    $custom_date = isset( $options['custom_date'] ) ? $options['custom_date'] : '';


	    if($custom_date != '' && !CBXBusinessHoursHelper::validateDate( $custom_date)){
		    $custom_date = '';
	    }



        ?>

        <p><?php esc_html_e('Which user role can see the widget', 'cbxbusinesshours') ?></p>
        <select id="" class="" name="role[]" multiple>
            <?php

            foreach (get_editable_roles() as $role_name => $role_info) {
                ?>
                <option <?php echo in_array($role_name, $role) ? ' selected' : ''; ?>
                        value="<?php echo $role_name; ?>"><?php echo esc_html__($role_info['name'], 'cbxbusinesshours'); ?></option>
            <?php } ?>
        </select>
		<p>
			<label for="cbxbusinesshours_compact"><?php echo esc_html__( 'Display Mode:', 'cbxbusinesshours' ) ?></label>
			<select name="cbxbusinesshours_compact"	id="cbxbusinesshours_compact">
			    <?php

				    $compact_options = array(
					    0 => esc_html__( 'Plain Table', 'cbxbusinesshours' ),
					    1 => esc_html__( 'Compact Table', 'cbxbusinesshours' )
				    );

				    foreach ( $compact_options as $key => $value ) {
					    ?>
						<option value="<?php echo $key; ?>" <?php selected( $compact, $key ) ?> > <?php echo $value; ?> </option>
				    <?php } ?>
			</select>
		</p>

		<p>
			<label for="cbxbusinesshours_time_format"><?php echo esc_html__( 'Time Format:', 'cbxbusinesshours' ) ?></label>
			<select name="cbxbusinesshours_time_format"	id="cbxbusinesshours_time_format">
			    <?php
				    $time_format_options = array(
					    24 => esc_html__( '24 hours', 'cbxbusinesshours' ),
					    12 => esc_html__( '12 hours', 'cbxbusinesshours' )
				    );


				    foreach ( $time_format_options as $key => $value ) {
					    ?>
						<option value="<?php echo $key; ?>" <?php selected( $time_format, $key ) ?> > <?php echo $value; ?> </option>
				    <?php } ?>
			</select>
		</p>

		<p>
			<label for="cbxbusinesshours_day_format"><?php echo esc_html__( 'Day Name Format:', 'cbxbusinesshours' ) ?></label>
			<select name="cbxbusinesshours_day_format"	id="cbxbusinesshours_day_format">
			    <?php
				    $day_format_options = array(
					    'long'  => esc_html__( 'Long', 'cbxbusinesshours' ),
					    'short' => esc_html__( 'Short', 'cbxbusinesshours' )
				    );


				    foreach ( $day_format_options as $key => $value ) {
					    ?>
						<option value="<?php echo $key; ?>" <?php selected( $day_format, $key ) ?> > <?php echo $value; ?> </option>
				    <?php } ?>
			</select>
		</p>

		<p>
			<label for="cbxbusinesshours_today"><?php echo esc_html__( 'Opening Days Display:', 'cbxbusinesshours' ) ?></label>
			<select name="cbxbusinesshours_today" id="cbxbusinesshours_today">
			    <?php
				    $today_options = array(
					    'week'      => esc_html__( 'Current Week(7 days)', 'cbxbusinesshours' ),
					    'today' => esc_html__( 'Today/For Current Date', 'cbxbusinesshours' )
				    );


				    foreach ( $today_options as $key => $value ) {
					    ?>
						<option value="<?php echo $key; ?>" <?php selected( $today, $key ) ?> > <?php echo $value; ?> </option>
				    <?php } ?>
			</select>
		</p>
		<p>
			<label for="cbxbusinesshours_custom_date"><?php echo esc_html__( 'Custom Date:', 'cbxbusinesshours' ) ?></label>
			<input type="text" autocomplete="off" class="cbxbusinesshours_custom_date" name="cbxbusinesshours_custom_date"	   id="cbxbusinesshours_custom_date"
				   value="<?php echo $custom_date; ?>">

		</p>
		<p><?php echo sprintf(esc_html__('Date format: %s', 'cbxbusinesshours'), 'Y-m-d'); ?></p>

        <?php
    }// end of method  widget_configure
}//end class CBXBusinessHoursDashboard