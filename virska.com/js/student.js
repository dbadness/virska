// jQuery and JS for the student controller

$(document).ready(function() {
	
	// Make sure the user knows that they're going to lose their note if they go back
	$('#delete').click(function() {
	   var answer = confirm("Are you sure you want to delete this note? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
	$('#dueToday').show("fast");

	$('#dueTodayLabel').click(function() {

		$('#dueToday').show();
		$('#dueWeek').hide();
		$('#searchDay').hide();
	});

	$('#dueWeekLabel').click(function() {

		$('#dueWeek').show();
		$('#dueToday').hide();
		$('#searchDay').hide();
	});

	$('#searchDayLabel').click(function() {

		$('#searchDay').show();
		$('#dueWeek').hide();
		$('#dueToday').hide();
	});
	
});