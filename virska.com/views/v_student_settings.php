<fieldset>
	<legend><strong>&nbsp&nbspContact Settings&nbsp&nbsp</strong></legend>
	<div class="spacer"></div>
	<form method="post" action="/student/p_update_contact">
		<div id="emailOld">
			Current Email: <?=$user->email?>
		</div>
		<div id="emailNew">
			<input name="email" value="<?=$user->email?>" size="40">
		</div>
		<div style="clear:both;"></div>
		<br>
		<div id="phoneOld">
			<div id="number">
				Current Phone: <?=$user->mobile?>
			</div>
			<div id="currentCarrier">
				Carrier: <?=$carrier?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div id="phoneNew">
			<div id="newCarrier">
				<?if($user->carrier == "@txt.att.net"):?>
					<select name="carrier">
						<option selected value="@txt.att.net">AT&T</option>
						<option value="@vtext.com">Verizon</option>
						<option value="@tmomail.net">T-Mobile</option>
						<option value="@messaging.sprintpcs.com">Sprint</option>
					</select>
				<?elseif($user->carrier == "@vtext.com"):?>
					<select name="carrier">
						<option value="@txt.att.net">AT&T</option>
						<option selected value="@vtext.com">Verizon</option>
						<option value="@tmomail.net">T-Mobile</option>
						<option value="@messaging.sprintpcs.com">Sprint</option>
					</select>
				<?elseif($user->carrier == "@tmomail.net"):?>
					<select name="carrier">
						<option value="@txt.att.net">AT&T</option>
						<option value="@vtext.com">Verizon</option>
						<option selected value="@tmomail.net">T-Mobile</option>
						<option value="@messaging.sprintpcs.com">Sprint</option>
					</select>
				<?elseif($user->carrier == "@messaging.sprintpcs.com"):?>
					<select name="carrier">
						<option value="@txt.att.net">AT&T</option>
						<option value="@vtext.com">Verizon</option>
						<option value="@tmomail.net">T-Mobile</option>
						<option selected value="@messaging.sprintpcs.com">Sprint</option>
					</select>
				<?elseif($user->carrier == ""):?>
					<select name="carrier">
						<option value="@txt.att.net">AT&T</option>
						<option value="@vtext.com">Verizon</option>
						<option value="@tmomail.net">T-Mobile</option>
						<option value="@messaging.sprintpcs.com">Sprint</option>
					</select>
				<?endif;?>
			</div>
			<div id="newNumber">
				<input name="mobile" value="<?=$user->mobile?>" size="14" maxlength="10">
			</div>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
		<br>
		<div id="contactSubmit">
			<input type="submit" value="Update Contact Info" class="submit">
		</div>
	</form>
	<div class="spacer"></div>
	<hr>
	<div class="spacer"></div>
	<div id="contact">
		<form method="post" action="/student/p_update_prefs">
			<div id="emailPref">
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
			</div>
			<br>
			<div id="phonePref">
				<div id="contactLabel">
					When a professor sends out a message, would you like to receive a text with their message?
				</div>
				<div id="contactRadio">
					<?if($user->receive_text == 1):?>
						Yes <input type="radio" name="receive_text" value="1" checked>
						No <input type="radio" name="receive_text" value="0">
					<?else:?>
						Yes <input type="radio" name="receive_text" value="1">
						No <input type="radio" name="receive_text" value="0" checked>
					<?endif;?>
				</div>
				<div style="clear:both;"></div>
			<div id="contactFunctions">
				<div id="contactUpdated">
					<?if(isset($contact_updated)):?>
						Contact preference successfully updated!
					<?endif;?>
				</div>
				<div id="prefsSubmit">
					<input type="submit" value="Update Preferences" class="submit">
				</div>
				<div style="clear:both;"></div>
			</div>
		</form>
	</div>
	<div style="clear:both;"></div>
	<div class="spacer"></div>
</fieldset>