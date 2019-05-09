<?php

class CBXBusinessHoursFrontWidget extends WP_Widget
{
    public $display_widget;


    /**
     * CBXBusinessHoursFrontWidget constructor.
     */
    public function __construct()
    {
        parent::__construct('cbxbusinesshours', esc_html__('CBX Business Hours', 'cbxbusinesshours'), array(
            'description' => esc_html__('CBX Business Hours Overview', 'cbxbusinesshours')
        ));
    }


    /**
     * @param array $instance
     * @return string|void
     */
    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : esc_html__('Business Hours', 'cbxbusinesshours');
        $compact = isset($instance['compact']) ? intval($instance['compact']) : 0;

        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')) ?>"><?php echo esc_html__('Title : ', 'cbxbusinesshours') ?></label>
            <input type="text" class="" name="<?php echo esc_attr($this->get_field_name('title')) ?>"
                   id="<?php echo esc_attr($this->get_field_id('title')) ?>"
                   value="<?php echo esc_html__($title, 'cbxbusinesshours') ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('compact')) ?>"><?php echo esc_html__('Display Mode : ', 'cbxbusinesshours') ?></label>
            <select name="<?php echo esc_attr($this->get_field_name('compact')); ?>"
                    id="<?php echo esc_attr($this->get_field_id('compact')); ?>">
                <?php
                $postType = array(
                    0 => esc_html__('Plain Table', 'cbxbusinesshours'),
                    1 => esc_html__('Compact Table', 'cbxbusinesshours')
                );
                foreach ($postType as $key => $value) {
                    ?>
                    <option value="<?php echo $key; ?>" <?php selected($compact, $key) ?> > <?php echo esc_html__($value, 'cbxbusinesshours') ?> </option>
                <?php } ?>
            </select>
        </p>
        <?php
    }// end of form method

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        $title = (!empty($instance['title'])) ? $instance['title'] : esc_html__('Business Hours', 'cbxbusinesshours');
        if (isset($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        wp_enqueue_style('cbxbusinesshours-public');

        echo CBXBusinessHoursHelper::business_hours_display($instance);

        echo $args['after_widget'];
    }//end method widget

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = (!empty($new_instance['title'])) ? $new_instance['title'] : '';
        $instance['compact'] = (!empty($new_instance['compact'])) ? $new_instance['compact'] : 0;
        return $instance;
    }// end of update method

}//end class CBXBusinessHoursFrontWidget