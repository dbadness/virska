$(document).ready(function() {

	// hide the nav buttons and user info so we have a clean looking page
	$('.navButton').css("display", "none");
	$('#userInfo').css("display", "none");
	
    $("form").submit(function() {
		// if the password is over eight characters and it matches the verified password field, let the form process
	    if ($(".passwords").val().length >= 8 && $("#password").val() == $("#passwordVal").val()) {
	      return true;
	    }
		// if those requirements aren't met, let's let the user know and cancel the form submission
	    $("#validateError").show();
		$('#emailValidator').effect("shake", { times:2 }, 50);
		$('.passwords').css("border", "solid 2px red");
	    return false;
	});
	
});