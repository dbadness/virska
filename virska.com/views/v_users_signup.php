<?if(isset($error)):?>
	<div id="noSchool">
		<h3>Your school hasn't been added to the list of Virska test schools yet.</h3>If you think Virska is something that's needed at your school, let us know by tweeting at us at @virska and we'll look into it!
	</div>
<?endif;?>
<div id="signupForm">
	<form class="signup" action='/users/p_signup' method='post' accept-charset='UTF-8'>
		<label for="role">Are you a student or a professor?</label><br>
	    <select name="role" id="role">
			<option value="student">Student</option>
			<option value="professor">Professor</option>
		</select>	

		<br><br>
		
		<label for="first_name">First Name</label><br>
	    <input name='first_name' id='first_name' />

		<br><br>		
		
		<label for="last_name">Last Name</label><br>
	    <input name='last_name' id='last_name' />

		<br><br>

		<label for="email">Email</label><br>
	    <input name='email' id='email'>

		<br><br>

	   	<input type='submit' value='Sign Up' />
	</form>
	<div style="float:left;margin-top:11px;" class="errorBox" id="noValuesError">
		Please make sure all boxes are filled in correctly.
	</div>
</div>
<div id="signupCopyWrapper">
	<div id="logos">
	<div class="spacer"></div>
		<div class="logo" id="bu">
			<img src="/images/bu.png" width="170">
		</div>
		<div class="logo" id="babson">
			<img src="/images/babson.png" width="170">
		</div>
		<div class="logo" id="suffolk">
			<img src="/images/suffolk.png" width="170">
		</div>
	</div>
	<div style="clear:left;"></div>
	<div class="spacer"></div>
	<div class="spacer"></div>
	<div id="signupCopy">
		Virska will only be available in these three schools while we test everything out. If you'd like Virska in your school, remember you can always shoot us a tweet to @virska to let us know!
	</div>
	<div class="spacer"></div>
</div>
<div style="clear: both;"></div>