<?php

class CBXBusinessHoursHelper
{
    /**
     * Returns business hours display as html
     *
     * @param array $atts
     */
    public static function business_hours_display($atts)
    {
        $optionValue = get_option('cbxbusinesshours_hours');

        $optionday = isset($optionValue['day']) ? $optionValue['day'] : array();


        $starting_time = array_column($optionday, 'start');
        $ending_time = array_column($optionday, 'end');


        $html = '';
        if (is_array($optionValue)) {
            $dow = array(

                array('long' => esc_html__('Sunday', 'cbxbusinesshours'), 'short' => esc_html__('Sun', 'cbxbusinesshours')),
                array('long' => esc_html__('Monday', 'cbxbusinesshours'), 'short' => esc_html__('Mon', 'cbxbusinesshours')),
                array('long' => esc_html__('Tuesday', 'cbxbusinesshours'), 'short' => esc_html__('Tue', 'cbxbusinesshours')),
                array('long' => esc_html__('Wednesday', 'cbxbusinesshours'), 'short' => esc_html__('Wed', 'cbxbusinesshours')),
                array('long' => esc_html__('Thursday', 'cbxbusinesshours'), 'short' => esc_html__('Thu', 'cbxbusinesshours')),
                array('long' => esc_html__('Friday', 'cbxbusinesshours'), 'short' => esc_html__('Fri', 'cbxbusinesshours')),
                array('long' => esc_html__('Saturday', 'cbxbusinesshours'), 'short' => esc_html__('Sat', 'cbxbusinesshours'))

            );

/*            $date = $exception['ex_date'];
            $day = date('l', strtotime($date));*/

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
                        $hours_text = $starting_time[$os[0]] . ' - ' . $ending_time[$os[0]];
                    } else {
                        $hours_text = '<span style="color: red">' . esc_html__('Closed', 'cbxbusinesshours') . '</span>';
                    }
                    $html .= '<tr>
                <td>' . $day_text . ':</td>
                <td>' . $hours_text . '</td>
            </tr>';
                }
                $html .= '</table>';
            }

        }else{
            echo '<h4>'.esc_html__('No schedule set yet!', 'cbxbusinesshours').'</h4>';
        }

        return $html;

    }//end method business_hours_display

}//end class CBXBusinessHoursHelper