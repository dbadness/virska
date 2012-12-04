// Login and Signup Page JS and jQuery

$(document).ready(function() {
	
    $("form").submit(function() {
      if ($("input").val() != 0) {
        return true;
      }
      	$("#noValuesError").show();
		$('#loginForm').effect("shake", { times:2 }, 50);
      return false;
    });
		
});