$(document).ready(function() {
	
	// Make sure the user knows that they're willing to delete their note
	$('.delete').click(function() {
	   var answer = confirm("Are you sure you want to delete this note? This action cannot be undone.");
	      if (!answer) {
	         return false;
	      } 
	});
	
	$("form").submit(function() {
      if ($("input").val() != 0) {
        return true;
      }
		$('#notesSearchBox').effect("shake", { times:2 }, 50);
      return false;
    });
	
});