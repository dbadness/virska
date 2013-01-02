// jQuery and JS for the student controller

$(document).ready(function() {
	
	// Make sure the user knows that they're going to lose their note if they go back
	$('#delete').click(function() {
	   var answer = confirm("Are you sure you want to delete this note? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
	$('.happening').click(function() {
		
		$('.active').removeClass('active').addClass('passive');
		$(this).addClass('active');
		
	})
	
	$('#dueTodayLabel').click(function() {
		$('#sDateLabel').hide();
		$('#sDescLabel').show();
		$('#sDescLabel').css("margin-left", "0px");
		$('#sClassLabel').show();
		$('#sClassLabel').css("margin-left", "20px");
		$('#dueToday').show();
		$('#dueWeek').hide();
		$('#searchDay').hide();
	});

	$('#dueWeekLabel').click(function() {
		$('#sClassLabel').show();
		$('#sClassLabel').css("margin-left", "0px");
		$('#sDateLabel').show();
		$('#sDescLabel').show();
		$('#sDescLabel').css("margin-left", "20px");
		$('#dueWeek').show();
		$('#dueToday').hide();
		$('#searchDay').hide();
	});

	$('#searchDayLabel').click(function() {
		$('#sDateLabel').hide();
		$('#sClassLabel').hide();
		$('#sDescLabel').hide();
		$('#searchDay').show();
		$('#dueWeek').hide();
		$('#dueToday').hide();
	});
	
	// because we're using the multiple lists in the same view, we have to distiguish the jQuery for each lists beginning and end
	$(".dayView:odd").css("background-color", "white");
	$(".dayView:even").css("background-color", "#CCFFFF");
	$(".dayView:first").css("border-top", "solid 1px gray");
	$(".dayView:last").css("border-bottom", "solid 1px gray");
	
	$(".weekView:odd").css("background-color", "white");
	$(".weekView:even").css("background-color", "#CCFFFF");
	$(".weekView:first").css("border-top", "solid 1px gray");
	$(".weekView:last").css("border-bottom", "solid 1px gray");
	
});