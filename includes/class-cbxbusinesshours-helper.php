<?php

class CBXBusinessHoursHelper {

	/**
	 * @return array
	 *
	 *  Get week long days with translation
	 */
	public static function getWeekLongDays() {
		$weekdays              = array();
		$weekdays['sunday']    = /* translators: weekday */
			__( 'Sunday' );
		$weekdays['monday']    = /* translators: weekday */
			__( 'Monday' );
		$weekdays['tuesday']   = /* translators: weekday */
			__( 'Tuesday' );
		$weekdays['wednesday'] = /* translators: weekday */
			__( 'Wednesday' );
		$weekdays['thursday']  = /* translators: weekday */
			__( 'Thursday' );
		$weekdays['friday']    = /* translators: weekday */
			__( 'Friday' );
		$weekdays['saturday']  = /* translators: weekday */
			__( 'Saturday' );

		return $weekdays;
	}//end method getWeekLongDays


	/**
	 * @return array
	 *
	 *  Get week long days keys
	 */
	public static function getWeekLongDayKeys() {
		$weekdays = CBXBusinessHoursHelper::getWeekLongDays();

		return array_keys( $weekdays );
	}//end method getWeekShortDayKeys


	/**
	 * @return array
	 *
	 *  Get week short days
	 */
	public static function getWeekShortDays() {
		$weekdays        = array();
		$weekdays['sun'] = /* translators: weekday */
			__( 'Sun' );
		$weekdays['mon'] = /* translators: weekday */
			__( 'Mon' );
		$weekdays['tue'] = /* translators: weekday */
			__( 'Tue' );
		$weekdays['wed'] = /* translators: weekday */
			__( 'Wed' );
		$weekdays['thu'] = /* translators: weekday */
			__( 'Thu' );
		$weekdays['fri'] = /* translators: weekday */
			__( 'Fri' );
		$weekdays['sat'] = /* translators: weekday */
			__( 'Sat' );

		return $weekdays;
	}//end method getWeekShortDays


	/**
	 * @return array
	 *
	 * Get week short days keys
	 */
	public static function getWeekShortDayKeys() {
		$weekdays = CBXBusinessHoursHelper::getWeekShortDays();

		return array_keys( $weekdays );
	}//end method getWeekShortDayKeys


	/**
	 * @param array $arr
	 *
	 * @return array
	 *
	 *  Find start days by general settings .
	 */
	public static function sortDaysWithFirstDayofWeek( $arr = array() ) {
		$start_of_week   = get_option( 'start_of_week' );
		$sliced_array    = array_slice( $arr, $start_of_week );
		$intersect_array = array_diff( $arr, $sliced_array );
		$arr             = array_merge( $sliced_array, $intersect_array );

		return $arr;
	}//end method sortDaysWithFirstDayofWeek

	public static function followWithFirstDayofWeekSorted( $office_weekdays, $weekdays ) {
		$weekdays_sorted = array();
		foreach ( $weekdays as $value ) {
			$weekdays_sorted[] = isset( $office_weekdays[ $value ] ) ? $office_weekdays[ $value ] : array();
		}
		$office_weekdays = $weekdays_sorted;

		return $office_weekdays;
	}//end method followWithFirstDayofWeekSorted


	/**
	 * @param $today
	 * @param $office_weekdays
	 *
	 * @return string
	 *
	 * Todays day and time return by date to todays parameter by shortcode .
	 */
	public static function todaysDateCheck( $today, $office_weekdays ) {

		$timestamp = strtotime( $today );
		$today     = strtolower( date( 'l', $timestamp ) );

		return ucwords( $today ) . " : " . $office_weekdays[ $today ]['start'] . " - " . $office_weekdays[ $today ]['end'];

	}

	/**
	 * @param $date
	 * @param string $format
	 *
	 * @return bool
	 *
	 * Check date format by shortcode today @param
	 */
	public static function validateDate( $date, $format = 'Y-m-d' ) {
		$d = DateTime::createFromFormat( $format, $date );

		return $d && $d->format( $format ) === $date;
	}

	/**
	 * Returns business hours display as html
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function business_hours_display( $atts ) {
		global $wp_locale;
		$optionValue = get_option( 'cbxbusinesshours_hours' );

		$office_weekdays = isset( $optionValue['weekdays'] ) ? $optionValue['weekdays'] : array();
		$exceptions      = isset( $optionValue['exceptionDay'] ) ? $optionValue['exceptionDay'] : array();
		$compact         = isset( $atts['compact'] ) ? $atts['compact'] : 0;
		$time_format     = isset( $atts['time_format'] ) ? $atts['time_format'] : 24;
		$length          = isset( $atts['length'] ) ? $atts['length'] : "long";

		//Get the week first day
		$start_of_week    = get_option( 'start_of_week' );
		$date             = new DateTime();
		$start_of_weekDay = $wp_locale->get_weekday( $start_of_week );

		//Current week start and end date
		$date->modify( $start_of_weekDay );
		$current_week_start_date = $date->format( 'Y-m-d' );
		$date->modify( $start_of_weekDay . 'this week +6 days' );
		$current_week_end_date = $date->format( 'Y-m-d' );


		if ( is_array( $exceptions ) && sizeof( $exceptions ) > 0 ) {
			foreach ( $exceptions as $exception ) {
				$ex_date = isset( $exception['ex_date'] ) ? $exception['ex_date'] : "";
				$ex_day  = date( 'l', strtotime( $ex_date ) );

				$found_day       = strtolower( $ex_day );
				$found_day_start = isset( $exception['ex_start'] ) ? $exception['ex_start'] : '';
				$found_day_end   = isset( $exception['ex_end'] ) ? $exception['ex_end'] : '';


				if ( isset( $office_weekdays[ $found_day ] ) ) {
					if ( $current_week_start_date <= $ex_date && $current_week_end_date >= $ex_date ) {
						$office_weekdays[ $found_day ]['start'] = $found_day_start;
						$office_weekdays[ $found_day ]['end']   = $found_day_end;
					}
				}
			}
		}


		if ( ! empty( $atts['today'] ) ) {
			if ( ! empty( $atts['today'] ) ) {

				$current_date = date( 'Y-m-d' );

				$today = $atts['today'] == "today" ? "today" : $atts['today'];

				if ( $today == "today" ) {
					return CBXBusinessHoursHelper::todaysDateCheck( $today, $office_weekdays );
				} else {
					if ( CBXBusinessHoursHelper::validateDate( $today ) && $today >= $current_date && $today < $current_week_end_date ) {
						return CBXBusinessHoursHelper::todaysDateCheck( $today, $office_weekdays );
					} else {
						return "<span style='color: red;font-weight: bold'>"
						       . esc_html__( 'Invalid input or date', 'cbxbussinesshours' ) .
						       "</span>";
					}
				}
			}
		}


		//sorting array by start of weekdays
		$weekdays        = CBXBusinessHoursHelper::getWeekLongDayKeys();
		$weekdays        = CBXBusinessHoursHelper::sortDaysWithFirstDayofWeek( $weekdays );
		$office_weekdays = CBXBusinessHoursHelper::followWithFirstDayofWeekSorted( $office_weekdays, $weekdays );

		//starting and ending time from database
		$starting_time = array_column( $office_weekdays, 'start' );
		$ending_time   = array_column( $office_weekdays, 'end' );

		$html = '';
		if ( is_array( $optionValue ) ) {

			$dow = array(
				'sunday'    => array(
					'long'  => esc_html__( 'Sunday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Sun', 'cbxbusinesshours' )
				),
				'monday'    => array(
					'long'  => esc_html__( 'Monday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Mon', 'cbxbusinesshours' )
				),
				'tuesday'   => array(
					'long'  => esc_html__( 'Tuesday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Tue', 'cbxbusinesshours' )
				),
				'wednesday' => array(
					'long'  => esc_html__( 'Wednesday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Wed', 'cbxbusinesshours' )
				),
				'thursday'  => array(
					'long'  => esc_html__( 'Thursday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Thu', 'cbxbusinesshours' )
				),
				'friday'    => array(
					'long'  => esc_html__( 'Friday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Fri', 'cbxbusinesshours' )
				),
				'saturday'  => array(
					'long'  => esc_html__( 'Saturday', 'cbxbusinesshours' ),
					'short' => esc_html__( 'Sat', 'cbxbusinesshours' )
				)
			);


			$dow = CBXBusinessHoursHelper::followWithFirstDayofWeekSorted( $dow, $weekdays );


			$key = $length;

			if ( $starting_time && $ending_time ) {

				$opening_short = array();
				for ( $i = 0; $i < 7; $i ++ ) {
					$temp = array( $i );
					for ( $j = $i + 1; $j < 7; $j ++ ) {

						if ( $compact == 0 ) {
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
						$end = array_pop( $os );
						$end = $dow[ $end ][ $key ];

						$day_text = $day_text . ' - ' . $end;
					}
					if ( ! empty( $starting_time[ $os[0] ] ) && ! ( $starting_time[ $os[0] ] == '0:00' && $ending_time[ $os[0] ] == '0:00' ) ) {

						if ( $time_format == 12 ) {
							$hours_text = date( "g:i a", strtotime( $starting_time[ $os[0] ] ) ) . ' - ' .
							              date( "g:i a", strtotime( $ending_time[ $os[0] ] ) );
						} else {
							$hours_text = $starting_time[ $os[0] ] . ' - ' . $ending_time[ $os[0] ];
						}

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
			echo '<p class="inline notice-warning">' . esc_html__( 'No schedule set yet!', 'cbxbusinesshours' ) . '</p>';
		}

		return $html;

	}//end method business_hours_display

}//end class CBXBusinessHoursHelper