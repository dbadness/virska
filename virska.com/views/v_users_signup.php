<div id="signupForm">
	<form class="signup" action='/users/p_signup' method='post' accept-charset='UTF-8'>
		<label for="role">Are you a student or a professor?</label><br>
	    <select name="role" id="role">
			<option value="student">Student</option>
			<option value="professor">Professor</option>
		</select>		

		<br><br>
		<label for="role">Which school do you attend?</label><br>		
	    <select name="school" id="school">
			<option value="Suffolk University">Suffolk University</option>
			<option value="Boston University">Boston University</option>
			<option value="University of Massachusetts">University of Massachusetts</option>
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
		Virska will only be available in these three schools while we test everything out. If you'd Virska in your school, remember you can always shoot us a tweet to @virska to let us know!
	</div>
	<div class="spacer"></div>
</div>
<div style="clear: both;"></div>