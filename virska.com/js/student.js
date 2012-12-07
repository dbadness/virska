// jQuery and JS for the student controller

$(document).ready(function() {
	
    var myNicEditor = new nicEditor();
    myNicEditor.setPanel('myNicPanel');
    myNicEditor.addInstance('myInstance1');
	
	// auto save the note every minute
	setInterval(function(){
		
		var content = $('#myInstance1').html();
			
        $.ajax({
                type: 'POST',
                url: '/student/p_auto_save_note',
				beforeSend: function() {
					$('#status').html("<img src=\"/images/ajax-loader.gif\"> Saving...");
				},
				complete: function() {
					$('#status').html("");
				},
                success: function(response) { 
                     // Load the results we get back from p_auto_save_note.php into the lastUpdated div
                        $('#lastUpdated').html(response);
                },
                data: {
                        note_id: $('#noteID').val(),
                        title: $('#noteTitle').val(),
                        content: content,
                },
        }); // end Ajax setup

	// The number below represents the interval (in milliseconds) between auto-saves	
	}, 5000);
	
	// when the user clicks on 'save note,' have the note be saved via ajax
	// This has to be fixed
	$('#saveNote').click(function() {
		
		var content = $('#myInstance1').html();
		
	    $.ajax({
	            type: 'POST',
	            url: '/student/p_save_note',
				beforeSend: function() {
					$('#status').html("<img src=\"/images/ajax-loader.gif\"> Saving...");
				},
				complete: function() {
					$('#status').html("");
				},
	            success: function(response) { 
	               	// Load the results we get back from p_auto_save_note.php into the lastUpdated div
	                $('#lastUpdated').html(response);
	            },
	            data: {
	                    note_id: 4,
	                    title: $('#noteTitle').val(),
	                    content: content,
	            },
	    }); // end Ajax setup
	}); // end button click event
		
});