<?php

if (!class_exists('CBXOpeningHours')) {

    /**
     * Class CBXOpeningHours
     *
     * Helper class
     */
    class CBXOpeningHours
    {

        /**
         * Returns business hours display as html
         *
         * @param array $atts
         */
        public static function business_hours_display($atts)
        {
            $optionValue = get_option('cbx_opening_hours');

            $exception_days = get_option('cbx_opening_hours_settings');


            if(!is_array($exception_days)) $exception_days = array();

            $exception_day = isset($exception_days['exception']) ? $exception_days['exception'] : array();

            $starting_time = array_column($optionValue, 'opening');
            $ending_time = array_column($optionValue, 'ending');

            $dow = array(

                array('long' => esc_html__('Sunday', 'cbx_opening_hours'), 'short' => esc_html__('Sun', 'cbx_opening_hours')),
                array('long' => esc_html__('Monday', 'cbx_opening_hours'), 'short' => esc_html__('Mon', 'cbx_opening_hours')),
                array('long' => esc_html__('Tuesday', 'cbx_opening_hours'), 'short' => esc_html__('Tue', 'cbx_opening_hours')),
                array('long' => esc_html__('Wednesday', 'cbx_opening_hours'), 'short' => esc_html__('Wed', 'cbx_opening_hours')),
                array('long' => esc_html__('Thursday', 'cbx_opening_hours'), 'short' => esc_html__('Thu', 'cbx_opening_hours')),
                array('long' => esc_html__('Friday', 'cbx_opening_hours'), 'short' => esc_html__('Fri', 'cbx_opening_hours')),
                array('long' => esc_html__('Saturday', 'cbx_opening_hours'), 'short' => esc_html__('Sat', 'cbx_opening_hours'))

            );

            $key = (false) ? 'short' : 'long';
            if ($starting_time && $ending_time) {

                $opening_short = array();
                for ($i = 0; $i < 7; $i++) {
                    $temp = array($i);
                    for ($j = $i + 1; $j < 7; $j++) {
                        if ($atts['compact'] == 0) {
                            $i = $j - 1;
                            $j = 7;
                        } elseif ($starting_time[$i] == $starting_time[$j] && $ending_time[$i] == $ending_time[$j]) {
                            $temp[] = $j;
                            if ($j == 6) $i = 6;
                        } else {
                            $i = $j - 1;
                            $j = 7;
                        }
                    }
                    $opening_short[] = $temp;
                }
            }

            $html = '';
            if (!empty($opening_short)) {
                $html .= '<table>';
                foreach ($opening_short as $os) {
                    $day_text = $dow[$os[0]][$key];
                    if (count($os) > 1) {
                        $end = array_pop($os);
                        $end = $dow[$end][$key];

                        $day_text = $day_text . ' - ' . $end;

                    }
                    if (!empty($starting_time[$os[0]]) && !($starting_time[$os[0]] == '0:00' && $ending_time[$os[0]] == '0:00')) {
                        //empty($exception['ex_start']) && empty($exception['ex_end']

                        foreach ($exception_day as $exception){
                            if (!empty($exception['ex_date'])){
                                $date = $exception['ex_date'];
                                $day = date('l', strtotime($date));
                            }
                        }

                        $hours_text = $starting_time[$os[0]] . ' - ' . $ending_time[$os[0]];
                    } else {
                        $hours_text = '<span style="color: red">' . esc_html__('Closed', 'cbx_opening_hours') . '</span>';
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


    } // end of class block
} // end of if condition
