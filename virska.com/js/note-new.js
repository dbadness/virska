$(document).ready(function() {
	
    var myNicEditor = new nicEditor();
    myNicEditor.setPanel('myNicPanel');
    myNicEditor.addInstance('notePad');

	// Save a new note on click
     $('#addNote').click(function() {
		
		if($('#notePad').html() == "" || $('#title').val() == "") {
			$('#title').val("Oh c'mon...");
			$('#notePad').html("...you've got to add some stuff to the note before you save it!");
			return false;
		}
	
		$.ajax({
        	type: 'POST',
        	url: '/student/p_add_note',
			beforeSend: function() {
				$('#statusImage').html("<img src=\"/images/ajax-loader.gif\">");
				$('#statusText').html("Saving...");
			},
			complete: function() {
				window.location.replace("/student/notes");
			},
            success: function(response) {
            },
            data: {
				section_id: $('#section').val(),
				title: $('#title').val(),
				content: $('#notePad').html(),
           	},
        }); // end ajax setup
		
	}); // end #addNote functionality
	
}); // end document ready