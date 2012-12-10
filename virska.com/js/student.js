// jQuery and JS for the student controller

$(document).ready(function() {
	
    var myNicEditor = new nicEditor();
    myNicEditor.setPanel('myNicPanel');
    myNicEditor.addInstance('notePad');

	// Save a new note on click
    $('#addNote').click(function() {
	
		$.ajax({
        	type: 'POST',
        	url: '/student/p_add_note',
			beforeSend: function() {
				$('#statusImage').html("<img src=\"/images/ajax-loader.gif\">");
				$('#statusText').html("Saving...");
			},
			complete: function() {
				$('#statusImage').html("");
				$('#statusText').html("Note Saved!");
			},
            success: function(response) { 
            	// Load the results we get back into the lastUpdated div
                $('#lastUpdated').html(response);
            },
            data: {
				section_id: $('#section').val(),
				title: $('#title').val(),
				content: $('#notePad').html(),
           	},
        }); // end ajax setup
	});
	
	// Make sure the user definately wants to go back and delete their note
	$('#cancel').click(function() {
		var msg = "Are you sure you want to delete the note?"
		
		if(!confirm(msg))
			return false;
	});

	// Manually save the note on click
    $('#saveNote').click(function() {
	
		$.ajax({
        	type: 'POST',
        	url: '/student/p_save_note',
			beforeSend: function() {
				$('#statusImage').html("<img src=\"/images/ajax-loader.gif\">");
				$('#statusText').html("Saving...");
			},
			complete: function() {
				$('#statusImage').html("");
				$('#statusText').html("");
			},
            success: function(response) { 
            	// Load the results we get back into the lastUpdated div
                $('#lastUpdated').html(response);
            },
            data: {
				note_id: $('#noteID').val(),
				title: $('#noteTitle').val(),
				content: $('#notePad').html(),
           	},
        }); // end ajax setup
	});
	
	setInterval(function() {
		$.ajax({
        	type: 'POST',
        	url: '/student/p_save_note',
			beforeSend: function() {
				$('#statusImage').html("<img src=\"/images/ajax-loader.gif\">");
				$('#statusText').html("Saving...");
			},
			complete: function() {
				$('#statusImage').html("");
				$('#statusText').html("");
			},
            success: function(response) { 
            	// Load the results we get back into the lastUpdated div
                $('#lastUpdated').html(response);
            },
            data: {
				note_id: $('#noteID').val(),
				title: $('#noteTitle').val(),
				content: $('#notePad').html(),
           	},
        }); // end ajax setup
	// The number below represents the interval, in milliseconds, on auto-save
	}, 60000);

});