// Login and Signup Page JS and jQuery

$(document).ready(function() {
	
		$('#loginForm').submit(function() {
			if ($("#loginFormEmailInput").val() == "" && $("#loginFormPasswordInput").val() == "") {
				$("#noValuesError").show();	
				$('#loginForm').effect("shake", { times:2 }, 50);
				return false;		
		    } else {
				return true;
			}
	    });
		
});