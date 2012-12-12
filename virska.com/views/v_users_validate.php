<div id="emailValidator">
	<form action="/users/p_validate" method="post">
		<label id="valLabel">Validation Code:</label><br>
		<input id="val_code" name="val_code">
		<br>
		<br>
		<label id="passwordLabel">New Password:</label>
		<input class="passwords" id="password" type="password">
		<br>
		<br>
		<label id="passwordValLabel">Verify Password:</label><br>
		<input class="passwords" id="passwordVal" name="password" type="password">
		<br>
		<br>
		<br>
		<input id="validate" type="submit" value="Validate">
	</form>
	<div class="errorBox" id="validateError">
		Either the passwords don't match or you need at least 8 characters in your password. Please try again.
	</div>
</div>