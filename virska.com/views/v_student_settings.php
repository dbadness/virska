<fieldset>
	<legend>Contact Settings</legend>
	<div id="emailLabel">
		Email:
	</div>
	<div id="emailCurrent">
		<?=$user->email?>
	</div>
	<div id="emailNew">
		<form method="post" action="/users/p_update_email">
			<div id="newEmailInput">
				<input type="hidden" name="user_id" value="<?=$user->user_id?>">
				<input name="email" value="<?=$user->email?>" size="40">
			</div>
			<div id="newEmailSubmit">
				<input type="submit" value="Update Email">
			</div>
			<div style="clear:both;"></div>
		</form>
	</div>
	<div style="clear:both;"></div>
</fieldset>