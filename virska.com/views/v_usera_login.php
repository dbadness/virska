<div class="form" id="loginForm">
	<form id='login' action='/usera/p_login' method='post' accept-charset='UTF-8'>
		
		<div class="formLabels loginText" id="loginFormUsernameLabel">
			Admin Username
		</div>
		<div class="formInputs loginText" id="loginFormEmailInput">
	    	<input type='text' name='username' id='email' />
		</div>
		<div style="clear: both;">
		</div>
		<div class="formLabels loginText" id="loginFormAdminPasswordLabel">
			Password
		</div>
		<div class="formInputs loginText" id="loginFormPasswordInput">
	    	<input type='password' name='password' id='password' />
		</div>
		<div style="clear: both;">
		</div>
		<div id="loginButton">
	   		<input type='submit' value='Log In' />	
		</div>
	</form>
	<?if(isset($error)):?>
		<div class="errorBox" id="adminError">
			Dude. Enter your shit right.
		</div>
	<?endif;?>
</div>