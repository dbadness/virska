$(document).ready(function() {

	$('.navButton').css("display", "none");
	
    $("form").submit(function() {
		// if the password is over eight characters and it matches the verified password field, let the form process
	    if ($("#password").val() >= 8 && $("#password").val() == $("#passwordVal").val()) {
	      return true;
	    }
	    $("#validateError").show();
		$('#loginForm').effect("shake", { times:2 }, 50);
		$('.passwords').css("border", "solid 2px red");
	    return false;
	});
	
});