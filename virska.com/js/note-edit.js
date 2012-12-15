$('document').ready(function() {
	
	// render the RTF editor
	var myNicEditor = new nicEditor();
    myNicEditor.setPanel('myNicPanel');
    myNicEditor.addInstance('notePad');
	
	// Manually save the note on click
	$('#saveNote').click(function() {

		$.ajax({
	    	type: 'POST',
	    	url: '/notes/p_save_note',
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
	    	url: '/notes/p_save_note',
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
	}, 5000);
	
}); // end document ready