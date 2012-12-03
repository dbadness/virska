// Login and Signup Page JS and jQuery

$(document).ready(function() {
	
		$('#loginForm').submit(function() {
			if ($("#loginFormEmailInput").length == 0 && $("#loginFormPasswordInput").length == 0) {
				$("#noValuesError").show();	
				$('#loginForm').effect("shake", { times:2 }, 50);
				return false;		
		    } else {
				return true;
			}
	    });
		
});