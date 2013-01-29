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
			
			# if the user's email doesn't match one of our partner's schools....
			
			$schools = array ("@babson.edu");
			
			$q = "SELECT email
			FROM users
			WHERE email = '".$_POST['email']."'";
			
			# check to see if their email already exists in the DB so they can't sign up again
			$exists = DB::instance(DB_NAME)->select_field($q);
			
			if(!in_array(strstr($_POST['email'], '@'), $schools)) {
			
				# send the user back to the signup page with the feedback that their school isn't added to virska yet
				Router::redirect("/users/notyet");
				return false;
				
			} elseif($exists) {
				
				Router::redirect("/users/signup_error");
				
			} else {
				
				$_POST['created'] = date("d-M-Y"); # this returns the current time
			
				# create the validation code that'll be used to authenticate the user's school affiliation
				$_POST['val_code'] = Utils::generate_random_string();
				
				# by default, they'll automatically start receiving emails from professors
				$_POST['receive_email'] = 1;
			
				# create token for cookie for sessions
				$_POST['token'] = sha1(TOKEN_SALT . $_POST['email'] . Utils::generate_random_string());
				
				# grab their school and put it into the DB
				$_POST['school'] = 'Babson College';
			
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
		}
		
		public function signup_error() {
			
			$this->template->content = View::instance("v_users_signup");
			$this->template->content->error = 1;
			echo $this->template;
			
		}
		
		public function notyet() {
			
			$error = 2;
			$this->template->content = View::instance("v_users_signup");
			$this->template->content->error = $error;
			$this->template->title = "Users Signup";
			
			echo $this->template;
		}
		
		public function admin_p_signup() {
			
			$insert['created'] = Time::now();
			$insert['modified'] = Time::now();
			$insert['email'] = ADMIN_EMAIL;
			$insert['password'] = sha1(ADMIN_PASSWORD);
			$insert['first_name'] = "David";
			$insert['last_name'] = "Baines";
			$insert['role'] = "admin";

			# create token for cookie for sessions
			$insert['token'] = sha1(TOKEN_SALT . $insert['email'] . Utils::generate_random_string());

			#insert data into the database
			DB::instance(DB_NAME)->insert('users', $insert);

			# Now let's refer to that token to make them a cookie so we can set up their first session
			$q = "SELECT token 
				FROM users 
				WHERE email = '".$insert['email']."'";

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
				Router::redirect("/admin/dashboard");
			}
		}
		
		public function p_validate_email() {
			
			if($this->user->role == "student") {
			
				# send the now-sessioned user an email with their velidation code
				# Build a multi-dimension array of recipients of this email
				$to[] = Array("name" => $this->user->first_name." ".$this->user->last_name, "email" => $this->user->email);

				# Build a single-dimension array of who this email is coming from
				# note it's using the constants we set in the configuration above)
				$from = Array("name" => APP_NAME, "email" => APP_EMAIL);

				# Subject
				$subject = "Welcome to Virska!";

				# You can set the body as just a string of text
				$body = "Welcome to Virska, ".$this->user->first_name.". <br><br>You can head to <a href=\"http://www.virska.com/users/validate\">the validation page</a> with the validation code '".$this->user->val_code."'.<br><br>Thanks,<br>The Virska Team";

				# OR, if your email is complex and involves HTML/CSS, you can build the body via a View just like we do in our controllers
				# $body = View::instance('e_users_welcome');

				# With everything set, send the email
				$email = Email::send($to, $from, $subject, $body, true);

				# Log the user out so they can't access other areas of the site until they're verified...
				# Generate and save a new token for next login
				$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

				# Create the data array we'll use with the update method
				# In this case, we're only updating one field, so our array only has one entry
				$data = Array("token" => $new_token);

				# Do the update
				DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

				# Delete their token cookie - effectively logging them out
				setcookie("token", "", strtotime('-1 year'), '/');
			
				Router::redirect("/users/validate");
				
			} else {
		
				# send the professor an email telling them that we're working on manually verifying them
				# Build a multi-dimension array of recipients of this email
				$to[] = Array("name" => $this->user->first_name." ".$this->user->last_name, "email" => $this->user->email);

				# Build a single-dimension array of who this email is coming from
				# note it's using the constants we set in the configuration above)
				$from = Array("name" => APP_NAME, "email" => APP_EMAIL);

				# Subject
				$subject = "Welcome to Virska!";

				# You can set the body as just a string of text
				$body = "Welcome to Virska, ".$this->user->first_name.". The Virska team is reviewing your identity and once your approved, we'll email you with your verification code to start using Virska.";

				# OR, if your email is complex and involves HTML/CSS, you can build the body via a View just like we do in our controllers
				# $body = View::instance('e_users_welcome');

				# With everything set, send the email
				$email = Email::send($to, $from, $subject, $body, true);
				
				Router::redirect("/users/p_thank_you");
				
			} # end if/else	
				
		}
		
		public function p_thank_you() {
			
			# send verification team an email with the user that wants to be added
			# Build a multi-dimension array of recipients of this email
			$to[] = Array("name" => "Verification Team", "email" => "verification@thinkedella.com");

			# Build a single-dimension array of who this email is coming from
			# note it's using the constants we set in the configuration above)
			$from = Array("name" => APP_NAME, "email" => APP_EMAIL);

			# Subject
			$subject = "A new professor wants to be validated.";

			# You can set the body as just a string of text
			$body = $this->user->first_name." ".$this->user->last_name." from ".$this->user->school." wants to be validated to use Virska.";

			# With everything set, send the email
			$email = Email::send($to, $from, $subject, $body, true);
			
			# Log the user out so they can't access other areas of the site until they're verified...
			# Generate and save a new token for next login
			$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

			# Create the data array we'll use with the update method
			# In this case, we're only updating one field, so our array only has one entry
			$data = Array("token" => $new_token);

			# Do the update
			DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

			# Delete their token cookie - effectively logging them out
			setcookie("token", "", strtotime('-1 year'), '/');
			
			# Redirect them to the "thank you for requesting access" page
			Router::redirect("/index/thank_you");
			
		}
		
		public function p_validate() {

			$q = "SELECT val_code
			FROM users
			WHERE email = '".$_POST['email']."'
			AND val_code = '".$_POST['val_code']."'";
			
			$success = DB::instance(DB_NAME)->select_field($q);
			
			if(!$success) {
			
				# give the user an error
				Router::redirect('/users/validate_error');
				return false;
				
			} else {
				
				# set up password hash and throw it into the database
				$password = sha1($_POST['password']);
				# Create the data array we'll use with the update method
				# In this case, we're only updating one field, so our array only has one entry
				$data = Array("password" => $password);

				# Do the update
				DB::instance(DB_NAME)->update("users", $data, "WHERE email = '".$_POST['email']."'");
				# Search the db for this email and password
				# Retrieve the token if it's available
				$q = "SELECT token
					FROM users 
					WHERE email = '".$_POST['email']."'";

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
					Router::redirect("/users/p_dashboard_signup");
			
				}
			}
		}
		
		public function validate_error() {
			
			$this->template->content = View::instance("v_users_validate");
			$this->template->content->error = 1;
			$client_files = Array(
						"/js/validate.js",
						"/css/validate.css"
	                    );
	
		    $this->template->client_files = Utils::load_client_files($client_files);
			echo $this->template;
			
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
			$_POST['password'] = sha1($_POST['password']);

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
				Router::redirect("/users/login_error/".$_POST['email']);

			# But if we did, login succeeded! 
			} else {

				# Store this token in a cookie
				setcookie("token", $token, strtotime('+2 weeks'), '/');
				
				# Send them to function that takes them to their dashboard
				Router::redirect("/users/p_dashboard_login");
			
			}
		}
		
		public function login_error($email) {
			$this->template->content = View::instance("v_users_login");
			$this->template->content->error = TRUE;
			$this->template->content->users_email = $email;
			$this->template->title   = "Users Login";
			echo $this->template;
		}
			
		public function p_dashboard_signup()	{
			
			if($this->user->role == 'student') {
				# Send them to their dashboard
				Router::redirect("/student/dashboard");
			} elseif($this->user->role == 'professor') {
				# set the professor up to make their first class
				Router::redirect("/professor/classes_new");
			}				
		}
		
		public function p_dashboard_login()	{
			
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
						"/js/validate.js",
						"/css/validate.css"
	                    );
	
		    $this->template->client_files = Utils::load_client_files($client_files);
			
			echo $this->template;
		}
		
		public function p_update_email() {
				
			$data = Array('email' => $_POST['email']);
			
			DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");
			
			Router::redirect("/student/settings");
		}

	}

?>