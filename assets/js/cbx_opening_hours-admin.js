$(document).ready(function () {

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

    // exceptional field added
    $(".main_wrapper").on('click', '.add_exception', function () {

        var $main_wrapper = $(".main_wrapper");
        var $ex_wrapper = $(".ex_wrapper");


        var $ex_last_count = $main_wrapper.find(".exception_last_count");

        var $ex_last_count_val = parseInt($ex_last_count.val());

        $ex_last_count_val++;

        $ex_last_count.val($ex_last_count_val);

        var field = "<p class='exception'>" +
            "<input type='text' name='cbx_opening_hours_settings[exception]["+$ex_last_count_val+"][ex_date]' placeholder='date' class='date' />" +
            " <input type='text' name='cbx_opening_hours_settings[exception]["+$ex_last_count_val+"][ex_start]' placeholder='start' />" +
            " <input type='text' name='cbx_opening_hours_settings[exception]["+$ex_last_count_val+"][ex_end]' placeholder='end'  />" +
            " <input type='text' name='cbx_opening_hours_settings[exception]["+$ex_last_count_val+"][ex_subject]' placeholder='subject' />" +
            "<a id='remove_exception'> Remove</a>" +
            "</p>";

        $main_wrapper.find($ex_wrapper).append(field);

        $($main_wrapper).on('click', '#remove_exception', function () {
            $(this).closest('.exception').remove();
        });

       $main_wrapper.find('.date').datepicker({
          dateFormat : 'dd-mm-yy'
       });


    }); // end exceptional field





});