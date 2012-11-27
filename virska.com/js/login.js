// Login and Signup Page JS and jQuery

$('document').ready(function() {
	
    $("#loginForm").submit(function() {
      if ($("#loginFormEmailInput").val() == "" && $("#loginFormPasswordInput").val() == "") {
        $("#noValuesError").show();
        return false;
      }
		return true;
    });
	
});