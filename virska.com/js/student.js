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
	});
	
	$('#dueTodayLabel').click(function() {
		$('.sDateLabel').hide();
		$('.sDescLabel').show();
		$('.sDescLabel').css("margin-left", "0px");
		$('.sClassLabel').show();
		$('.sClassLabel').css("margin-left", "20px");
		$('#dueToday').show();
		$('#dueWeek').hide();
		$('#searchDay').hide();
		$('#searchDayActive').hide();
	});

	$('#dueWeekLabel').click(function() {
		$('.sDateLabel').show();
		$('.sClassLabel').show();
		$('.sClassLabel').css("margin-left", "0px");
		$('.sDescLabel').show();
		$('.sDescLabel').css("margin-left", "20px");
		$('#dueWeek').show();
		$('#dueToday').hide();
		$('#searchDay').hide();
		$('#searchDayActive').hide();
	});

	$('#searchDayLabel').click(function() {
		$('.sDateLabel').show();
		$('.sClassLabel').show();
		$('.sClassLabel').css("margin-left", "0px");
		$('.sDescLabel').show();
		$('.sDescLabel').css("margin-left", "20px");
		$('#searchDay').show();
		$('#dueWeek').hide();
		$('#dueToday').hide();
		$('#searchDayActive').show();
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
	
	$(".searchView:odd").css("background-color", "white");
	$(".searchView:even").css("background-color", "#CCFFFF");
	$(".searchView:first").css("border-top", "solid 1px gray");
	$(".searchView:last").css("border-bottom", "solid 1px gray");
	
	$("form").submit(function() {
		if ($("#file").val() != 0) {
			return true;
		}
		if ($(".inputs").val() != 0) {
			return true;
		}
		if ($("#message").val() != 0) {
			return true;
		}
		$(this).effect("shake", { times:2 }, 50);
		return false;
    });

	// if the student submits a submission with no file, give them feedback
	$(".submission").submit(function() {
      	if ($("#file").val() != 0) {
        	return true;
      	}
		$(this).effect("shake", { times:2 }, 50);
      	return false;
    });

	$(".submissionList:odd").css("background-color", "white");
	$(".submissionList:even").css("background-color", "#CCFFFF");
	$(".submissionList:first").css("border-top", "solid 1px gray");
	$(".submissionList:last").css("border-bottom", "solid 1px gray");
	
	$(function() {
	    $("#datepicker").datepicker();
	    $("#format").change(function() {
	        $("#datepicker").datepicker( "option" , "dateFormat", $(this).val() );
	    });
	});
	
});