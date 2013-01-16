<div id="loginForm">
	<form id='login' action='/users/p_login' method='post' accept-charset='UTF-8'>
		<div id="loginFormEmailLabel">
			Email
		</div>
		<div id="loginFormEmailInput">
	    	<input type='text' name='email' id='email' class="textfield">
		</div>
		<div style="clear:both;"></div>
		<div id="loginFormPasswordLabel">
			Password
		</div>
		<div id="loginFormPasswordInput">
	    	<input type='password' name='password' id='password' class="textfield">
		</div>
		<div style="clear:both;"></div>
		<div id="loginButton">
	   		<input type='submit' value='Log In' class="submit">	
		</div>
		<div style="clear:right;"></div>
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