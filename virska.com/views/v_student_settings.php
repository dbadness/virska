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
	<div class="spacer"></div>
	<hr>
	<div class="spacer"></div>
	<div id="contact">
		<form method="post" action="/student/p_update_contact">
			<div id="contactLabel">
				When a professor sends out a message, would you like to receive an email with their message?
			</div>
			<div id="contactRadio">
				<?if($user->receive_email == 1):?>
					Yes <input type="radio" name="receive_email" value="1" checked>
					No <input type="radio" name="receive_email" value="0">
				<?else:?>
					Yes <input type="radio" name="receive_email" value="1">
					No <input type="radio" name="receive_email" value="0" checked>
				<?endif;?>
			</div>
			<div style="clear:both;"></div>
			<div id="contactFunctions">
				<div id="contactUpdated">
					<?if(isset($contact_updated)):?>
						Contact preference successfully updated!
					<?endif;?>
				</div>
				<div id="contactSubmit">
					<input type="submit" value="Update" class="submit">
				</div>
				<div style="clear:both;"></div>
			</div>
		</form>
	<div style="clear:both;"></div>
	<div class="spacer"></div>
</fieldset>