(function ($) {

    $(document).ready(function () {

        /**
         *  @timepicker function
         */
        function timepicker() {
            // timepicker
            $('.timepicker').timepicker({
                timeFormat: 'H:mm',
                interval: 15,
                minTime: '10',
                maxTime: '6:00pm',
                startTime: '00:00',
                dropdown: true,
                scrollbar: true
            });
        }

        /**
         * @datepicker function
         */
        function datepicker() {
            // date picker
            $(".date").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        }


        // exceptional field added
        $(".ex_wrapper").on('click', '.add_exception', function () {

            var $this = $(this);

            var $ex_wrapper = $this.closest(".ex_wrapper");
            var $ex_items = $ex_wrapper.find(".ex_items");

            var $ex_last_count = $ex_wrapper.find('.exception_last_count');
            var $ex_last_count_val = parseInt($ex_last_count.val());

            $ex_last_count_val++;

            $ex_last_count.val($ex_last_count_val);

            var field = "<p class='ex_item'>" +
                "<input type='text' required autocomplete='off' name='cbxbusinesshours_hours[exception][" + $ex_last_count_val + "][ex_date]' placeholder='" + translation['date'] + "' class='date'/>" +
                " <input type='text' class='timepicker' autocomplete='off' name='cbxbusinesshours_hours[exception][" + $ex_last_count_val + "][ex_start]' placeholder='" + translation['start'] + "' />" +
                " <input type='text' class='timepicker' autocomplete='off' name='cbxbusinesshours_hours[exception][" + $ex_last_count_val + "][ex_end]' placeholder='" + translation['end'] + "'  />" +
                " <input type='text' autocomplete='off' name='cbxbusinesshours_hours[exception][" + $ex_last_count_val + "][ex_subject]' placeholder='" + translation['subject'] + "' />" +
                " <a class='remove_exception button'>" +
                "<span class='dashicons dashicons-trash' style='margin-top: 3px;color: red;'></span>"
                + translation['remove'] +
                "</a>" +
                "</p>";

            $ex_wrapper.find($ex_items).append(field);

            timepicker();
            datepicker();


        }); // end exceptional field

        // Remove field
        $(".ex_wrapper").on('click', '.remove_exception', function (e) {
            e.preventDefault();

            var $this = $(this);

            $this.closest(".ex_item").remove();
        });

        // show date ui
        $(".ex_wrapper").on('click', '.date', function () {
            datepicker();
        });

        // show date ui
        $(".ex_wrapper").on('click', '.timepicker', function () {
            timepicker();
        });


    });

})(jQuery);