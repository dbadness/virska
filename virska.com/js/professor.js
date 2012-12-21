$(document).ready(function() {

	$(function() {
	    $("#datepicker").datepicker();
	    $("#format").change(function() {
	        $("#datepicker").datepicker( "option" , "dateFormat", $(this).val() );
	    });
	});
	
	$("#attachmentCheckbox").click(function() {
		$("#ifAttachment").show();
		$("#assignmentButton").css("margin-top", "-7px");
	});
});