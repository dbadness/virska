<?php
	
	class users_controller extends base_controller {
		
		public function __construct() {
			parent::__construct();
			
			# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						"/css/login.css",
						"/js/login.js",
	                    );
	
		    $this->template->client_files = Utils::load_client_files($client_files);
		}
		
		public function index() {
			Router::redirect("/");
		}

		public function signup() {
			$this->template->content = View::instance("v_users_signup");
			$this->template->title   = "Users Signup";
			echo $this->template;	
		}
		
		public function p_signup() {
			
			#hash the password
			# $_POST['password'] = sha1(PASSWORD_SALT . $_POST['password']);
			$_POST['created'] = Time::now(); # this returns the current time
			$_POST['modified'] = Time::now(); # this returns the current time
			
			# create the validation code that'll be used to authenticate the user's school affiation
			$_POST['val_code'] = Utils::generate_random_string();
			
			# create token for cookie for sessions
			$_POST['token'] = sha1(TOKEN_SALT . $_POST['email'] . Utils::generate_random_string());
			
			#insert data into the database
			DB::instance(DB_NAME)->insert('users', $_POST);
			
			# Now let's refer to that token to make them a cookie so we can set up their first session
			$q = "SELECT token 
				FROM users 
				WHERE email = '".$_POST['email']."'";

			$token = DB::instance(DB_NAME)->select_field($q);	

			# If we didn't get a token back, login failed
			if(!$token) {

				# Send them back to the login page with an error message
				Router::redirect("/users/login_error");

			# But if we did, login succeeded! 
			} else {

				# Store this token in a cookie
				setcookie("token", $token, strtotime('+2 weeks'), '/');

				# Send them to the main page - or whever you want them to go
				Router::redirect("/users/p_validate_email");
			}
		}
		
		public function p_validate_email() {
			
			# send the now-sessioned user an email with their velidation code
			# Build a multi-dimension array of recipients of this email
			$to[] = Array("name" => $this->user->first_name, "email" => $this->user->email);

			# Build a single-dimension array of who this email is coming from
			# note it's using the constants we set in the configuration above)
			$from = Array("name" => APP_NAME, "email" => APP_EMAIL);

			# Subject
			$subject = "Welcome to Virska!";

			# You can set the body as just a string of text
			$body = "Welcome to Virska for ".$this->user->school.", ".$this->user->first_name."! <br><br>Your validation code is: ".$this->user->val_code;

			# OR, if your email is complex and involves HTML/CSS, you can build the body via a View just like we do in our controllers
			# $body = View::instance('e_users_welcome');

			# With everything set, send the email
			$email = Email::send($to, $from, $subject, $body, true);
			
			Router::redirect("/users/validate");
			
		}
		
		public function p_validate() {
			
			$q = "SELECT val_code
			FROM users
			WHERE email = '".$this->user->email."'
			AND val_code = '".$_POST['val_code']."'";
			
			$success = DB::instance(DB_NAME)->select_field($q);
			
			if($success) {
				
				# set up password hash and throw it into the database
				$password = sha1($_POST['password']);
				# Create the data array we'll use with the update method
				# In this case, we're only updating one field, so our array only has one entry
				$data = Array("password" => $password);

				# Do the update
				DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");
				
				
				# you don't need to set up a token for a session because the signup already did that
				
				Router::redirect("/users/p_dashboard");
			} else {
				$error = TRUE;
				Router::redirect("/users/validate");
			}
		}
		
		public function login() {
						
			$this->template->content = View::instance("v_users_login");
			$this->template->title   = "Users Login";
			echo $this->template;
		}
		
		
		public function p_login() {
			
			# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

			# Hash submitted password so we can compare it against one in the db
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

			# Search the db for this email and password
			# Retrieve the token if it's available
			$q = "SELECT token
				FROM users 
				WHERE email = '".$_POST['email']."' 
				AND password = '".$_POST['password']."'";

			$token = DB::instance(DB_NAME)->select_field($q);	

			# If we didn't get a token back, login failed
			if(!$token) {

				# Send them back to the login page with an error
				Router::redirect("/users/login_error");

			# But if we did, login succeeded! 
			} else {

				# Store this token in a cookie
				setcookie("token", $token, strtotime('+2 weeks'), '/');
				
				# Send them to function that takes them to their dashboard
				Router::redirect("/users/p_dashboard");
			
			}
		}
		
		public function login_error() {
			$this->template->content = View::instance("v_users_login");
			$this->template->content->error = TRUE;
			echo $this->template;
		}
			
		public function p_dashboard()	{
			
			# Send them to their dashboard
			Router::redirect("/".$this->user->role."/dashboard");
							
		}
		
		public function logout() {
			# Generate and save a new token for next login
			$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

			# Create the data array we'll use with the update method
			# In this case, we're only updating one field, so our array only has one entry
			$data = Array("token" => $new_token);

			# Do the update
			DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

			# Delete their token cookie - effectively logging them out
			setcookie("token", "", strtotime('-1 year'), '/');

			# Send them back to the main landing page
			Router::redirect("/");
		}
		
		public function validate() {
			
			$this->template->content = View::instance("v_users_validate");
			
			$client_files = Array(
						"/js/email-validate.js",
						"/css/validate.css"
	                    );
	
		    $this->template->client_files = Utils::load_client_files($client_files);
			
			echo $this->template;
		}
	}

?>