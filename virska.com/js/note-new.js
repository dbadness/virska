$(document).ready(function() {
	
    var myNicEditor = new nicEditor();
    myNicEditor.setPanel('myNicPanel');
    myNicEditor.addInstance('notePad');

	// Make sure the user knows that they're going to lose their note if they go back
	$('#cancel').click(function() {
	   var answer = confirm("Are you sure you want to delete this note and return to all notes?");
	      if (!answer) {
	         return false;
	      } 
	});

	// Save a new note on click
     $('#addNote').click(function() {
	
		// don't let the user enter a blank note - give 'em a snarky message
		if($('#notePad').html() == "" || $('#title').val() == "") {
			$('#title').val("Oh c'mon...");
			$('#notePad').html("...you've got to add some stuff to the note before you save it!");
			return false;
		}
		
		// if everything's good to go, let's make an ajax call, store the note, and send them to editing for the auto-save feature
		$.ajax({
        	type: 'POST',
        	url: '/student/p_add_note',
			beforeSend: function() {
				$('#statusImage').html("<img src=\"/images/ajax-loader.gif\">");
				$('#statusText').html("Saving...");
			},
            success: function(response) {
				window.location.replace("/student/notes_edit/" + response);
            },
            data: {
				section_id: $('#section').val(),
				title: $('#title').val(),
				content: $('#notePad').html(),
           	},
        }); // end ajax setup
	}); // end #addNote functionality
}); // end document ready