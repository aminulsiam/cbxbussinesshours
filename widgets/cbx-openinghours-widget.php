<?php

/**
 * Adds Opening_Hours_Widget widget.
 */

if (!class_exists('Opening_Hours_Widget')) {

    class Opening_Hours_Widget extends WP_Widget
    {

        /**
         * Register widget .
         */
        function __construct()
        {
            parent::__construct(
                'opeing_hours_widget', // Base ID
                esc_html__('CBX Opening hours', 'cbx_opening_hours'), // Name
                array('description' => esc_html__('A Foo Widget', 'cbx_opening_hours'),) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         */
        public function widget($args, $instance)
        {
            echo $args['before_widget'];
            if (!empty($instance['title'])) {
                echo $args['before_title'];

                echo '<h2>'.$instance['title'].'</h2>';

                echo CBXOpeningHours::business_hours_display($instance);

                echo $args['after_title'];
            }
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         */
        public function form($instance)
        {
            $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Title', 'cbx_opening_hours');
            $compact = isset($instance['compact']) ? $instance['compact'] : 1;
            ?>
            <p>
                <label
                        for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('compact')) ?>">
                    <?php echo esc_html__('Table Type : ', 'cbx_opening_hours') ?>
                </label>

                <select name="<?php echo esc_attr($this->get_field_name('compact')); ?>" class="widefat">
                    <?php
                    $postType = array(
                        0 => esc_html__('Plain Table', 'cbx_opening_hours'),
                        1 => esc_html__('Compact Table', 'cbx_opening_hours')
                    );
                    foreach ($postType as $key => $value) {
                        ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($compact); ?>>
                            <?php echo esc_attr($value) ?>
                        </option>
                    <?php } ?>
                </select>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values .
         *
         * @see WP_Widget::update()
         */
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            $instance['compact'] = (!empty($new_instance['compact'])) ? $new_instance['compact'] : 0;

            return $instance;
        }

    } // class Foo_Widget
} // End class exists block