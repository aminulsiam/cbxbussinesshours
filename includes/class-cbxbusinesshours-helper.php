<?php

/**
 * Helper class
 *
 * Class CBXBusinessHoursHelper
 */
class CBXBusinessHoursHelper {
	/**
	 * Returns business hours display as html
	 *
	 * @param $atts
	 *
	 * @return string
	 * @throws Exception
	 */
	public static function business_hours_display( $atts ) {

		$compact = isset( $atts['compact'] ) ? $atts['compact'] : 0;

		$optionValue = get_option( 'cbxbusinesshours_hours' );

		$exceptions = isset( $optionValue['exceptions'] ) ? $optionValue['exceptions'] : array();
		$weekdays   = isset( $optionValue['weekdays'] ) ? $optionValue['weekdays'] : array();


		$start_weekday_option_val = get_option( 'start_of_week' );

		// get starts day from wordpress general settings
		global $wp_locale;
		$start_weekday = $wp_locale->get_weekday( $start_weekday_option_val );


		// get last day and first day at current week
		date_default_timezone_set( 'Asia/Dhaka' );
		$date = new DateTime();

		$date->modify( $start_weekday . ' this week' );  // todo : from general page get the starts week days
		$current_week_start_date = $date->format( 'Y-m-d' );

		write_log($current_week_start_date);

		$date->modify( $start_weekday . 'this week +5 days' ); // todo : last date of the week form starts
		$current_week_end_date = $date->format( 'Y-m-d' );


		if ( is_array( $exceptions ) && sizeof( $exceptions ) > 0 ) {
			foreach ( $exceptions as $exception ) {

				$ex_date = isset( $exception['ex_date'] ) ? $exception['ex_date'] : "";
				$ex_day = date( 'l', strtotime( $ex_date ) );

				$found_day = strtolower( $ex_day );

				$found_day_start = isset($exception['ex_start']) ? $exception['ex_start'] : "";
				$found_day_end   = isset($exception['ex_end']) ? $exception['ex_end'] : "";


				if ( isset( $weekdays[ $found_day ] ) ) {
					if ( $ex_date >= $current_week_start_date && $ex_date <= $current_week_end_date) {
						$weekdays[ $found_day ]['start'] = $found_day_start;
						$weekdays[ $found_day ]['end']   = $found_day_end;
					}
				}
			}
		}

		$starting_time = array_column( $weekdays, 'start' );
		$ending_time   = array_column( $weekdays, 'end' );

		$html = '';
		if ( is_array( $optionValue ) ) {
			$dow = array(

				array(
					'long'  => esc_html__( 'Sunday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Sun', 'cbxbusinesshours' )
				),
				array(
					'long'  => esc_html__( 'Monday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Mon', 'cbxbusinesshours' )
				),
				array(
					'long'  => esc_html__( 'Tuesday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Tue', 'cbxbusinesshours' )
				),
				array(
					'long'  => esc_html__( 'Wednesday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Wed', 'cbxbusinesshours' )
				),
				array(
					'long'  => esc_html__( 'Thursday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Thu', 'cbxbusinesshours' )
				),
				array(
					'long'  => esc_html__( 'Friday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Fri', 'cbxbusinesshours' )
				),
				array(
					'long'  => esc_html__( 'Saturday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Sat', 'cbxbusinesshours' )
				)

			);


			$key = ( false ) ? 'short' : 'long';
			if ( $starting_time && $ending_time ) {
				$opening_short = array();
				for ( $i = 0; $i < 7; $i ++ ) {
					$temp = array( $i );
					for ( $j = $i + 1; $j < 7; $j ++ ) {
						if ( intval( $compact ) == 0 ) {
							$i = $j - 1;
							$j = 7;
						} elseif ( $starting_time[ $i ] == $starting_time[ $j ] && $ending_time[ $i ] == $ending_time[ $j ] ) {
							$temp[] = $j;
							if ( $j == 6 ) {
								$i = 6;
							}
						} else {
							$i = $j - 1;
							$j = 7;
						}
					}
					$opening_short[] = $temp;
				}
			}

			if ( ! empty( $opening_short ) ) {
				$html .= '<table>';

				foreach ( $opening_short as $os ) {
					$day_text = $dow[ $os[0] ][ $key ];

					if ( count( $os ) > 1 ) {
						$end      = array_pop( $os );
						$end      = $dow[ $end ][ $key ];
						$day_text = $day_text . ' - ' . $end;
					}

					if ( ! empty( $starting_time[ $os[0] ] ) && ! ( $starting_time[ $os[0] ] == '0:00' && $ending_time[ $os[0] ] == '0:00' ) ) {

						/*foreach ( $exceptions as $value ) {

							$ex_date = isset( $value['ex_date'] ) ? $value['ex_date'] : "";
							$ex_day  = date( 'l', strtotime( $ex_date ) );

							// current 7days
							$days   = [];
							$period = new DatePeriod(
								new DateTime(), // Start date of the period
								new DateInterval( 'P1D' ), // Define the intervals as Periods of 1 Day
								6 // Apply the interval 6 times on top of the starting date
							);

							foreach ( $period as $day ) {
								$days[] = $day->format( 'l' );
							}

							if ( in_array( $ex_day, $days ) ) {
								foreach ( $days as $current_day ) {
									if ( $ex_day == $current_day ) {

									}
								}
							} else {
								$hours_text = $starting_time[ $os[0] ] . ' - ' . $ending_time[ $os[0] ];
							}*/


						$hours_text = $starting_time[ $os[0] ] . ' - ' . $ending_time[ $os[0] ];


					} else {
						$hours_text = '<span style="color: red">' . esc_html__( 'Closed', 'cbxbusinesshours' ) . '</span>';
					}
					$html .= '<tr>
                <td>' . $day_text . ':</td>
                <td>' . $hours_text . '</td>
            </tr>';
				}
				$html .= '</table>';
			}

		} else {
			echo '<h4>' . esc_html__( 'No schedule set yet!', 'cbxbusinesshours' ) . '</h4>';
		}

		return $html;

	}//end method business_hours_display

}//end class CBXBusinessHoursHelper