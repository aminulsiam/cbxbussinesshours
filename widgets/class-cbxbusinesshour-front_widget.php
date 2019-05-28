<?php

	// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	class CBXBusinessHoursFrontWidget extends WP_Widget {
		public $display_widget;


		/**
		 * CBXBusinessHoursFrontWidget constructor.
		 */
		public function __construct() {
			parent::__construct( 'cbxbusinesshours', esc_html__( 'CBX Business Hours', 'cbxbusinesshours' ), array(
				'description' => esc_html__( 'CBX Business Hours Overview', 'cbxbusinesshours' )
			) );
		}


		/**
		 * @param array $instance
		 *
		 * @return string|void
		 */
		public function form( $instance ) {
			$title       = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Business Hours', 'cbxbusinesshours' );

			$compact     = isset( $instance['compact'] ) ? intval( $instance['compact'] ) : 0;
			$time_format = isset( $instance['time_format'] ) ? intval( $instance['time_format'] ) : 24;
			$day_format  = isset( $instance['day_format'] ) ? $instance['day_format'] : 'long';
			$today       = isset( $instance['today'] ) ? $instance['today'] : 'week';
			$custom_date = isset( $instance['custom_date'] ) ? $instance['custom_date'] : '';

			if($custom_date != '' && !CBXBusinessHoursHelper::validateDate( $custom_date)){
				$custom_date = '';
			}

			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"><?php echo esc_html__( 'Title:', 'cbxbusinesshours' ) ?></label>
				<input type="text" class="" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>"
					   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
					   value="<?php echo $title; ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'compact' ) ) ?>"><?php echo esc_html__( 'Display Mode:', 'cbxbusinesshours' ) ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'compact' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'compact' ) ); ?>">
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'time_format' ) ) ?>"><?php echo esc_html__( 'Time Format:', 'cbxbusinesshours' ) ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'time_format' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'time_format' ) ); ?>">
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'day_format' ) ) ?>"><?php echo esc_html__( 'Day Name Format:', 'cbxbusinesshours' ) ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'day_format' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'day_format' ) ); ?>">
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'today' ) ) ?>"><?php echo esc_html__( 'Opening Days Display:', 'cbxbusinesshours' ) ?></label>
				<select name="<?php echo esc_attr( $this->get_field_name( 'today' ) ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'today' ) ); ?>">
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'custom_date' ) ) ?>"><?php echo esc_html__( 'Custom Date:', 'cbxbusinesshours' ) ?></label>
				<input type="text" autocomplete="off" class="cbxbusinesshours_custom_date" name="<?php echo esc_attr( $this->get_field_name( 'custom_date' ) ) ?>"
					   id="<?php echo esc_attr( $this->get_field_id( 'custom_date' ) ) ?>"
					   value="<?php echo $custom_date; ?>">

			</p>
			<p><?php echo sprintf(esc_html__('Date format: %s', 'cbxbusinesshours'), 'Y-m-d'); ?></p>


			<?php
		}// end of form method

		/**
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];
			$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Business Hours', 'cbxbusinesshours' );
			if ( isset( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			//wp_enqueue_style( 'cbxbusinesshours-public' );
			if($instance['today'] == 'week') $instance['today'] = '';

			if($instance['today'] == 'today' && $instance['custom_date'] != '' && CBXBusinessHoursHelper::validateDate( $instance['custom_date'])){
				$instance['today'] = esc_attr($instance['custom_date']);
			}

			echo CBXBusinessHoursHelper::business_hours_display( $instance );

			echo $args['after_widget'];
		}//end method widget

		/**
		 * @param array $new_instance
		 * @param array $old_instance
		 *
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {

			$instance                = $old_instance;
			$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? $new_instance['title'] : '';
			$instance['compact']     = ( ! empty( $new_instance['compact'] ) ) ? $new_instance['compact'] : 0;
			$instance['time_format'] = ( ! empty( $new_instance['time_format'] ) ) ? $new_instance['time_format'] : 24;
			$instance['day_format']  = ( ! empty( $new_instance['day_format'] ) ) ? $new_instance['day_format'] : 'long';
			$instance['today']       = ( ! empty( $new_instance['today'] ) ) ? $new_instance['today'] : 'week';
			$instance['custom_date']       = ( ! empty( $new_instance['custom_date'] ) ) ? $new_instance['custom_date'] : ''; //y-m-d

			if($instance['custom_date'] != '' && !CBXBusinessHoursHelper::validateDate( $instance['custom_date'])){
				$instance['custom_date'] = '';
			}


			return $instance;
		}// end of update method

	}//end class CBXBusinessHoursFrontWidget