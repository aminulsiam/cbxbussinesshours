<?php

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
		$title       = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Bussiness Hours', 'cbxbusinesshours' );
		$compact     = isset( $instance['compact'] ) ? intval( $instance['compact'] ) : 0;
		$time_format = isset( $instance['time_format'] ) ? intval( $instance['time_format'] ) : 0;
		$length      = isset( $instance['length'] ) ? $instance['length'] : 'long';

		?>
        <div class="wp-tab-panel">
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"><?php echo esc_html__( 'Title : ', 'cbxbusinesshours' ) ?></label>
                <input type="text" class="" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>"
                       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ) ?>"
                       value="<?php echo esc_html__( $title, 'cbxbusinesshours' ) ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'compact' ) ) ?>"><?php echo esc_html__( 'Display Mode : ', 'cbxbusinesshours' ) ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'compact' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'compact' ) ); ?>">
					<?php
					$postType = array(
						0 => esc_html__( 'Plain Table', 'cbxbusinesshours' ),
						1 => esc_html__( 'Compact Table', 'cbxbusinesshours' )
					);
					foreach ( $postType as $key => $value ) {
						?>
                        <option value="<?php echo $key; ?>" <?php selected( $compact, $key ) ?> > <?php echo esc_html__( $value, 'cbxbusinesshours' ) ?> </option>
					<?php } ?>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'time_format' ) ) ?>"><?php echo esc_html__( 'Time format : ', 'cbxbusinesshours' ) ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'time_format' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'time_format' ) ); ?>">
					<?php
					$time_formats = array(
						24 => esc_html__( '24 hours', 'cbxbusinesshours' ),
						12 => esc_html__( '12 hours', 'cbxbusinesshours' )
					);


					foreach ( $time_formats as $key => $value ) {
						?>
                        <option value="<?php echo $key; ?>" <?php selected( $time_format, $key ) ?> > <?php echo esc_html__( $value, 'cbxbusinesshours' ) ?> </option>
					<?php } ?>
                </select>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ) ?>"><?php echo esc_html__( 'Length : ', 'cbxbusinesshours' ) ?></label>
                <select name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>">
					<?php
					$lengths = array(
						'long'  => esc_html__( 'Long', 'cbxbusinesshours' ),
						'short' => esc_html__( 'Short', 'cbxbusinesshours' )
					);


					foreach ( $lengths as $key => $value ) {
						?>
                        <option value="<?php echo $key; ?>" <?php selected( $length, $key ) ?> > <?php echo esc_html__( $value, 'cbxbusinesshours' ) ?> </option>
					<?php } ?>
                </select>
            </p>


        </div>
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

		wp_enqueue_style( 'cbxbusinesshours-public' );

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
		$instance['length']      = ( ! empty( $new_instance['length'] ) ) ? $new_instance['length'] : 'long';

		return $instance;
	}// end of update method

}//end class CBXBusinessHoursFrontWidget