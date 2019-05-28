(function ($) {
	'use strict';

	$(document).ready(function ($) {
		// date picker
		$(document).on('focus',".cbxbusinesshours_custom_date", function(){
			$(this).datepicker({
				dateFormat: 'yy-mm-dd'
			})
		});

	});

})(jQuery);