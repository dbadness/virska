$(document).ready(function() {

	$(".listItem:odd").css("background-color", "white");
	$(".listItem:even").css("background-color", "#CCFFFF");
	$(".listItem:first").css("border-top", "solid 1px gray");
	$(".listItem:last").css("border-bottom", "solid 1px gray");
	
	$("textarea").autoGrow();
	
});