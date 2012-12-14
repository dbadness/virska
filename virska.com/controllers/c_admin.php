<?php

class admin_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		Router::redirect("/");
		
	}
	
	public function login() {
		
		$this->template->content = View::instance("v_admin_login");
		$this->template->title = "Virska Admin Login";	

		$client_files = Array(
					"/js/login.js",
					"/css/login.css",
					"/css/main.css"
                    );

	    $this->template->client_files = Utils::load_client_files($client_files);	
		
		echo $this->template;
	}
	
	public function p_login() {
		
		# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		# Hash submitted password so we can compare it against one in the db
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		# Search the db for this email and password
		# Retrieve the token if it's available
		$q = "SELECT *
			FROM admins 
			WHERE username = '".$_POST['username']."' 
			AND password = '".$_POST['password']."'";

		$token = DB::instance(DB_NAME)->select_field($q);	

		# If we didn't get a token back, login failed
		if(!$token) {

			# Send them back to the login page with an error
			Router::redirect("/admin/login_error");

		# But if we did, login succeeded! 
		} else {

			# Store this token in a cookie
			setcookie("token", $token, strtotime('+2 weeks'), '/');
			
			# Send them to function that takes them to their dashboard
			Router::redirect("/admin/dashboard");
		
		}
	}
	
	public function login_error() {
		$this->template->content = View::instance("v_admin_login");
		$this->template->content->error = TRUE;
		echo $this->template;
	}
	
	public function logout() {
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->username.Utils::generate_random_string());

		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update("admins", $data, "WHERE token = '".$this->user->token."'");

		# Delete their token cookie - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		# Send them back to the main landing page
		Router::redirect("/admin/login");
	}
	
	public function dashboard() {
		
		# find the professors that have yet to be validated
		$q = "SELECT *
		FROM users
		WHERE password = ''
		AND role = 'professor'";
		
		$professors = DB::instance(DB_NAME)->select_rows($q);		
		
		$this->template->content = View::instance("v_admin_dashboard");
		$this->template->content->professors = $professors;
		$client_files = Array(
					"/js/admin.js",
					"/css/admin.css"
                    );
					
	    $this->template->client_files = Utils::load_client_files($client_files);
		$this->template->title = "Admin Dashboard";
		
		
		echo $this->template;
	}
	
	public function p_validate($user_id) {
		
		# select the professor we want to validate from the foreach loop in the dashboard view
		$q = "SELECT *
		FROM users
		WHERE user_id = ".$user_id;
		
		$professor = DB::instance(DB_NAME)->select_row($q);
		
		# send the professor an email wit their verification code
		# Build a multi-dimension array of recipients of this email
		$to[] = Array("name" => $professor['first_name']." ".$professor['last_name'], "email" => $professor['email']);

		# Build a single-dimension array of who this email is coming from
		# note it's using the constants we set in the configuration above)
		$from = Array("name" => APP_NAME, "email" => APP_EMAIL);

		# Subject
		$subject = "You've been validated!";

		# You can set the body as just a string of text
		$body = "Dear ".$professor['first_name'].",<br><br>Thank you so much for your patience while we validated your identity. You can now head to our <a href='localhost/users/validate'>validation page</a> with the validation code ".$professor['val_code']." to unlock Virska.<br><br>Thanks!<br><br>The Virska Verification Team";

		# OR, if your email is complex and involves HTML/CSS, you can build the body via a View just like we do in our controllers
		# $body = View::instance('e_users_welcome');

		# With everything set, send the email
		$email = Email::send($to, $from, $subject, $body, true);

		# Throw a numer "1" into the 'verifed' column in the users DB to show that this user has been verified
		$data = Array("validated" => 1);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$professor['user_id']."'");
		
		Router::redirect("/admin/dashboard");
		
	}
	
} // end class