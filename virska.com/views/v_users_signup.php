<div style="width: 400px;">
	<form id='login' class="form" action='/users/p_signup' method='post' accept-charset='UTF-8'>
		<label for="role">Are you a student or a professor?</label>
	    <select name="role" id="role">
			<option value="student">Student</option>
			<option value="professor">Professor</option>
		</select>		

		</br></br>
		
		<label for="first_name">First Name</label>
	    <input type='text' name='first_name' id='first_name' />

		</br></br>		
		
		<label for="last_name">Last Name</label>
	    <input type='text' name='last_name' id='last_name' />

		</br></br>

		<label for="email">Email</label>
	    <input type='text' name='email' id='email' />

		</br></br>

		<label for="password">Password</label>
	   	<input type='password' name='password' id='password' />

		</br></br>

	   	<input type='submit' value='Sign Up' />
	</form>
	<div style="clear: both;">
	</div>
</div>