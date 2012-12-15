$(document).ready(function() {

	$(function() {
	    $( "#datepicker" ).datepicker();
	    $( "#format" ).change(function() {
	        $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
	    });
	});
	
	// alternate colors in lists on the professor controllers' views
	$(".assignment:odd").css("background-color", "white");
	$(".assignment:even").css("background-color", "#CCFFFF");

});