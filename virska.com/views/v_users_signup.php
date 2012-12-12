<div style="width:400px;">
	<form id='login' class="form" action='/users/p_signup' method='post' accept-charset='UTF-8'>
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
	    <input name='email' id='email' />

		<br><br>

	   	<input type='submit' value='Sign Up' />
	</form>
	<div style="clear: both;">
	</div>
</div>