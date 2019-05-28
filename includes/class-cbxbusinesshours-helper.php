<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class CBXBusinessHoursHelper {

	public static function daysOfWeek() {
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

		return $dow;
	}//end method daysOfWeek

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

	/**
	 * Convert the store weekdays sorted with the first day of week
	 *
	 * @param $office_weekdays
	 * @param $weekdays
	 *
	 * @return array
	 */
	public static function followWithFirstDayofWeekSorted( $office_weekdays, $weekdays ) {
		$weekdays_sorted = array();
		foreach ( $weekdays as $value ) {
			$weekdays_sorted[] = isset( $office_weekdays[ $value ] ) ? $office_weekdays[ $value ] : array();
		}
		$office_weekdays = $weekdays_sorted;

		return $office_weekdays;
	}//end method followWithFirstDayofWeekSorted


	/**
	 * Todays day and time return by date to todays parameter by shortcode
	 *
	 * @param $today
	 * @param $office_weekdays
	 *
	 * @return string
	 *
	 */
	public static function todaysDateCheck( $today, $office_weekdays ) {

		$timestamp = strtotime( $today );
		$today     = strtolower( date( 'l', $timestamp ) );

		$today_start = isset( $office_weekdays[ $today ]['start'] ) ? $office_weekdays[ $today ]['start'] : "";
		$today_end   = isset( $office_weekdays[ $today ]['end'] ) ? $office_weekdays[ $today ]['end'] : "";

		return ucwords( $today ) . " : " . $today_start . " - " . $today_end;
	}

	/**
	 * Check date format for given date [source https://stackoverflow.com/a/19271434]
	 *
	 * @param string $date
	 * @param string $format
	 *
	 * @return bool
	 *
	 */
	public static function validateDate( $date, $format = 'Y-m-d' ) {
		$d = DateTime::createFromFormat( $format, $date );

		return $d && $d->format( $format ) === $date;
	}//end method validateDate

	/**
	 * Returns business hours display as html
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public static function business_hours_display( $atts ) {
		if ( is_admin() ) {
			wp_enqueue_style( 'cbxbusinesshours-admin' );
		} else {
			wp_enqueue_style( 'cbxbusinesshours-public' );
		}


		$current_offset = get_option( 'gmt_offset' );
		$tzstring       = get_option( 'timezone_string' );

		$check_zone_info = true;

		// Remove old Etc mappings. Fallback to gmt_offset.
		if ( false !== strpos( $tzstring, 'Etc/GMT' ) ) {
			$tzstring = '';
		}

		if ( empty( $tzstring ) ) { // Create a UTC+- zone if no timezone string exists
			$check_zone_info = false;
			if ( 0 == $current_offset ) {
				$tzstring = '+0';
			} elseif ( $current_offset < 0 ) {
				$tzstring = '' . $current_offset;
			} else {
				$tzstring = '+' . $current_offset;
			}
		}


		//three timezone types:  https://stackoverflow.com/questions/17694894/different-timezone-types-on-datetime-object/17711005#17711005
		$date_time_zone = new DateTimeZone( $tzstring );

		global $wp_locale;
		$dow = CBXBusinessHoursHelper::daysOfWeek();

		$date_format   = 'Y-m-d';
		$date_time_now = new DateTime( 'now', $date_time_zone );
		date_time_set( $date_time_now, 0, 0, 0 );

		$setting = new CBXBusinessHoursSettings();


		$office_weekdays = $setting->get_option( 'weekdays', 'cbxbusinesshours_hours', array() );

		//$exceptions      = isset( $optionValue['dayexception'] ) ? $optionValue['dayexception'] : array();
		$dayexception = $setting->get_option( 'dayexception', 'cbxbusinesshours_hours', array() );
		$exceptions   = isset( $dayexception['dayexceptions'] ) ? $dayexception['dayexceptions'] : array();


		$compact     = isset( $atts['compact'] ) ? intval( $atts['compact'] ) : 0;
		$time_format = isset( $atts['time_format'] ) ? intval( $atts['time_format'] ) : 24;
		$day_format  = isset( $atts['day_format'] ) ? esc_attr( $atts['day_format'] ) : 'long';

		//Get the week first day
		$start_of_week     = intval( get_option( 'start_of_week' ) ); //index following sunday as first day of week
		$start_of_weekDay  = $wp_locale->get_weekday( $start_of_week ); //Day name in format: Sunday
		$start_of_the_week = strtotime( "Last $start_of_weekDay" );

		if ( strtolower( date( 'l' ) ) === strtolower( $start_of_weekDay ) ) {
			$start_of_the_week = strtotime( 'today' );
		}

		$end_of_the_week = $start_of_the_week + ( 60 * 60 * 24 * 7 ) - 1;

		$current_week_start_date = new DateTime( '@' . $start_of_the_week, $date_time_zone );
		$current_week_end_date   = new DateTime( '@' . $end_of_the_week, $date_time_zone );


		$process_today  = false;
		$today_date     = '';
		$today_date_str = '';
		$today_day      = '';


		$today = isset( $atts['today'] ) ? esc_attr( $atts['today'] ) : '';
		if ( $today != '' ) {

			if ( $today == 'today' ) {

				//$today_date     = new DateTime('now', $date_time_zone);
				$today_date = $date_time_now;

				$today_date_str = $today_date->format( $date_format );
				$today_day      = strtolower( $today_date->format( 'l' ) ); //get the day from date
				$process_today  = true;

			} else if ( CBXBusinessHoursHelper::validateDate( $today ) ) {
				$today_date = DateTime::createFromFormat( $date_format, $today, $date_time_zone );
				date_time_set( $today_date, 0, 0, 0 );

				//if ( $today_date < new DateTime('now', $date_time_zone) ) {
				if ( $today_date < $date_time_now ) {

					return esc_html__( 'The date has already passed', 'cbxbusinesshours' );
				}

				$today_date_str = $today_date->format( $date_format );
				$today_day      = strtolower( $today_date->format( 'l' ) ); //get the day from date
				$process_today  = true;
			} else {
				return esc_html__( 'Invalid Date', 'cbxbusinesshours' );
			}
		}


		if ( is_array( $exceptions ) && sizeof( $exceptions ) > 0 ) {
			foreach ( $exceptions as $exception ) {
				$ex_date = isset( $exception['ex_date'] ) ? esc_attr( $exception['ex_date'] ) : '';
				if ( $ex_date == '' ) {
					continue;
				}

				if ( ! CBXBusinessHoursHelper::validateDate( $ex_date ) ) {
					continue;
				}

				//$ex_day  = date( 'l', strtotime( $ex_date ) ); //get the day from date
				$ex_date = DateTime::createFromFormat( $date_format, $ex_date, $date_time_zone );
				date_time_set( $ex_date, 0, 0, 0 );

				$found_day       = strtolower( $ex_date->format( 'l' ) ); //get the day from date
				$found_day_start = isset( $exception['ex_start'] ) ? $exception['ex_start'] : '';
				$found_day_end   = isset( $exception['ex_end'] ) ? $exception['ex_end'] : '';

				if ( $process_today ) {
					if ( $today_date == $ex_date ) {
						$office_weekdays[ $today_day ]['start'] = $found_day_start;
						$office_weekdays[ $today_day ]['end']   = $found_day_end;

						break;
					}
				} else {
					if ( $ex_date >= $current_week_start_date && $ex_date <= $current_week_end_date ) {
						$office_weekdays[ $found_day ]['start'] = $found_day_start;
						$office_weekdays[ $found_day ]['end']   = $found_day_end;
					}
				}
			}
		}

		if ( $process_today ) {

			$today_start       = isset( $office_weekdays[ $today_day ]['start'] ) ? $office_weekdays[ $today_day ]['start'] : '';
			$today_end         = isset( $office_weekdays[ $today_day ]['end'] ) ? $office_weekdays[ $today_day ]['end'] : '';
			$today_day_display = isset( $dow[ $today_day ][ $day_format ] ) ? $dow[ $today_day ][ $day_format ] : ucfirst( $today_day );


			$cbxbusinesshours_display_today_closed = '';

			if ( $today_start == '' || $today_end == '' ) {
				$today_start_end                       = esc_html__( 'Closed', 'cbxbusinesshours' );
				$cbxbusinesshours_display_today_closed = 'cbxbusinesshours_display_today_closed';
			} else if ( $time_format == '12' ) {
				$today_start = date( "g:i a", strtotime( $today_start ) );
				$today_end   = date( "g:i a", strtotime( $today_end ) );

				$today_start_end = $today_start . " - " . $today_end;
			} else {
				$today_start_end = $today_start . " - " . $today_end;
			}


			return '<p class="cbxbusinesshours_display cbxbusinesshours_display_today ' . $cbxbusinesshours_display_today_closed . '">' . $today_day_display . ': ' . $today_start_end . '</p>';
		}


		//sorting array by start of weekdays
		$weekdays        = CBXBusinessHoursHelper::getWeekLongDayKeys();
		$weekdays        = CBXBusinessHoursHelper::sortDaysWithFirstDayofWeek( $weekdays );
		$office_weekdays = CBXBusinessHoursHelper::followWithFirstDayofWeekSorted( $office_weekdays, $weekdays );

		//starting and ending time from database
		$starting_time = array_column( $office_weekdays, 'start' );
		$ending_time   = array_column( $office_weekdays, 'end' );

		$html = '';


		$dow = CBXBusinessHoursHelper::followWithFirstDayofWeekSorted( $dow, $weekdays );


		$key = $day_format;

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
			$html .= '<table class="cbxbusinesshours_display cbxbusinesshours_display_week">';
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
					$hours_text = '<span class="cbxbusinesshours_display_week_closed">' . esc_html__( 'Closed', 'cbxbusinesshours' ) . '</span>';
				}
				$html .= '<tr>
                <td>' . $day_text . ':</td>
                <td>' . $hours_text . '</td>
                
            </tr>';
			}
			$html .= '</table>';
		}


		return $html;

	}//end method business_hours_display

	/**
	 * @param array $value
	 *
	 * @return mixed
	 */
	public static function sanitize_callback_dayexception( $dayexception ) {
		if ( is_array( $dayexception ) && sizeof( $dayexception ) > 0 ) {
			$exceptions = isset( $dayexception['dayexceptions'] ) ? $dayexception['dayexceptions'] : array();


			if ( is_array( $exceptions ) && sizeof( $exceptions ) > 0 ) {
				foreach ( $exceptions as $key => $exception ) {
					$date = $exception['ex_date'];
					if ( $date == '' || ! CBXBusinessHoursHelper::validateDate( $date ) ) {
						unset( $exceptions[ $key ] );
					}
				}

				$dayexception['dayexceptions'] = $exceptions;
			}
		}

		return $dayexception;
	}//end method sanitize_callback_dayexception

}//end class CBXBusinessHoursHelper