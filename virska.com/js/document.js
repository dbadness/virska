$(document).ready(function(){

	// Make sure the user knows that they're willing to delete this file reference from our server
	$('.delete').click(function() {
	   var answer = confirm("Are you sure you want to delete this file? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
	$("form").submit(function() {
      if ($("#file").val() != 0) {
        return true;
      }
     	$("#docLimit").html("<i>Please choose a file first.</i>");
		$("#docLimitBox").css("border", "solid red 1px");
		$("#docLimitBox").css("background-color", "beige");
		$("#docLimitBox").css("padding", "11");
		$('#docLimitBox').effect("shake", { times:2 }, 50);
      return false;
    });
	
});