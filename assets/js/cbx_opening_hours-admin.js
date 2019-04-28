$(document).ready(function(){

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

	// chosen plugin
	$(".chosen-select").chosen();
});