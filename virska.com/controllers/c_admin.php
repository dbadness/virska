<?php

class admin_controller extends base_controller {

	public function __construct() {
		parent::__construct();

		if($this->user->role != 'admin') {
			Router::redirect("/");
			return false;
		}	
	}
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		Router::redirect("/");
		
	}
	
	public function dashboard() {
		
		# find the professors that have yet to be validated
		$q = "SELECT *
		FROM users
		WHERE password = ''
		AND role = 'professor'";
		
		$professors = DB::instance(DB_NAME)->select_rows($q);	
		
		$q = "SELECT
		COUNT(user_id)
		FROM users";
		
		$usercount = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT SUM(size)
		FROM documents";
		
		$db_size = DB::instance(DB_NAME)->select_field($q);	
		
		$this->template->content = View::instance("v_admin_dashboard");
		$this->template->content->professors = $professors;
		$this->template->content->db_size = $db_size;
		$this->template->content->usercount = $usercount;
		$client_files = Array(
					"/js/admin.js",
					"/css/admin.css",
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
?>