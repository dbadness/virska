// jQuery and JS for the student controller

$(document).ready(function() {
	
	// Make sure the user knows that they're going to lose their note if they go back
	$('#delete').click(function() {
	   var answer = confirm("Are you sure you want to delete this note? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});

});