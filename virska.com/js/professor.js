$(document).ready(function() {

	$(function() {
	    $("#datepicker").datepicker();
	    $("#format").change(function() {
	        $("#datepicker").datepicker( "option" , "dateFormat", $(this).val() );
	    });
	});
	
	$("#addAttachment").click(function() {
		$("#attachment").show();
		$("#eventDate").css("margin-top", "-41px");
		$("#submissions").css("margin-top", "-40px");
		$(this).css("width", "170px");
		$(this).css("height", "20px");
		$(this).html("Add an Attachment <div id=\"attachmentCheck\"><img src='/images/checkmark.png' width='25'></div><div style='clear:right;'></div>");
	}); 
	
	// Make sure the user knows that they're willing to delete their event
	$('#deleteEvent').click(function() {
	   var answer = confirm("Are you sure you want to delete this event? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
	// Make sure the user knows that they're willing to delete their event
	$('#deleteClassButton').click(function() {
	   var answer = confirm("Are you sure you want to delete this class? All sections will also be erased from Virska permanently and this action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
	$(".submissionList:odd").css("background-color", "white");
	$(".submissionList:even").css("background-color", "#CCFFFF");
	$(".submissionList:first").css("border-top", "solid 1px gray");
	$(".submissionList:last").css("border-bottom", "solid 2px gray");
	
	$('#feedbackField').keyup(function() {

		length = $(this).val().length;
		count = 300 - length;
		$('#charCount').html(count);
	});
	
	
	// error checking regarding blank inputs on adding classes
	$("form:first").submit(function() {
		if (($("#class_name").val().length > 0) && ($("#class_code").val().length > 0)) {
			return true;
		}
		$('form:first').effect("shake", { times:2 }, 50);
		return false;
    });


	// error checking regarding blank inputs on adding sections
	$("form:last").submit(function() {
		if (($("#section_name").val().length > 0) && ($("#roomNumber").val().length > 0) && ($("#building").val().length > 0)) {
			return true;
		}
		$('form:last').effect("shake", { times:2 }, 50);
		return false;
    });

	$(".messageContainer:last").css("border-bottom", "solid 0px gray");

});