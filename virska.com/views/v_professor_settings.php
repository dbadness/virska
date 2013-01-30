<fieldset>
	<legend><strong>&nbsp&nbspContact Settings&nbsp&nbsp</strong></legend>
	<div class="spacer"></div>
	<div id="emailLabel">
		Email:
	</div>
	<div id="emailCurrent">
		<?=$user->email?>
	</div>
	<div id="emailNew">
		<form method="post" action="/professor/p_update_contact">
			<div id="newEmailInput">
				<input type="hidden" name="user_id" value="<?=$user->user_id?>">
				<input name="email" value="<?=$user->email?>" size="40">
			</div>
			<div id="newEmailSubmit">
				<input type="submit" value="Update Email" class="submit">
			</div>
			<div style="clear:both;"></div>
		</form>
	</div>
	<div style="clear:both;"></div>
	<div class="spacer"></div>
</fieldset>