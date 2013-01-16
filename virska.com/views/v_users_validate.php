<div id="emailValidator">
	<form action="/users/p_validate" method="post">
		<label id="emailValLabel">School Email:</label><br>
		<input id="emailVal" name="email">
		<br>
		<br>
		<label id="valLabel">Validation Code from Email:</label><br>
		<input id="val_code" name="val_code">
		<br>
		<br>
		<label id="passwordLabel">Create a Password:</label>
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
	<div class="errorBox" id="valuesError">
		Either the passwords don't match or you need at least 8 characters in your password. Please try again.
	</div>
	<?if($error):?>
		<div class="errorBox" id="valError">
			That validation code doesn't seem to be right. Please enter it again.
		</div>
	<?endif;?>
</div>