$(document).ready(function(){

	// Make sure the user knows that they're willing to delete this file reference from our server
	$('.delete').click(function() {
	   var answer = confirm("Are you sure you want to delete this file? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
});