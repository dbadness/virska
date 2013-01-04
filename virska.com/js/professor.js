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
	
	$(".submissionList:odd").css("background-color", "white");
	$(".submissionList:even").css("background-color", "#CCFFFF");
	$(".submissionList:first").css("border-top", "solid 1px gray");
	$(".submissionList:last").css("border-bottom", "solid 2px gray");
	
	$('#feedbackField').keyup(function() {

		length = $(this).val().length;
		count = 300 - length;
		$('#charCount').html(count);
	});

});