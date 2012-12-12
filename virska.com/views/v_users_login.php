<div class="form" id="loginForm">
	<form id='login' action='/users/p_login' method='post' accept-charset='UTF-8'>
		
		<div class="formLabels loginText" id="loginFormEmailLabel">
			Email
		</div>
		<div class="formInputs loginText" id="loginFormEmailInput">
	    	<input type='text' name='email' id='email' />
		</div>
		<div style="clear: both;">
		</div>
		<div class="formLabels loginText" id="loginFormPasswordLabel">
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
		<div class="errorBox" id="noMatchError">
			Hmm... Couldn't find that user. Please try again.
		</div>
	<?endif;?>
	<div class="errorBox" id="noValuesError">
		Please enter a valid email address and password.
	</div>
</div>