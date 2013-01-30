<?php

class admin_controller extends base_controller {

	public function __construct() {
		parent::__construct();

		if($this->user->role != 'admin') {
			Router::redirect("/");
			return false;
		}
		
		$client_files = Array(
					"/js/admin.js",
					"/css/admin.css",
					"/css/jquery.jqplot.min.css",
					"/js/jquery.jqplot.js",
					"/js/jqplot.dateAxisRenderer.min.js",
					"/js/jqplot.highlighter.min.js",
					"/js/jqplot.cursor.min.js",
                    );
					
	    $this->template->client_files = Utils::load_client_files($client_files);
	}

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
		
		$q = "SELECT SUM(size)
		FROM documents";
		
		$db_size = DB::instance(DB_NAME)->select_field($q);	
		
		$q = "SELECT count(user_id)
		FROM users";
		
		$users = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT count(user_id)
		FROM users
		WHERE role = 'student'";

		$student_users = DB::instance(DB_NAME)->select_field($q);
	
		$q = "SELECT count(user_id)
		FROM users
		WHERE role = 'professor'";

		$professor_users = DB::instance(DB_NAME)->select_field($q);
		
		$this->template->content = View::instance("v_admin_dashboard");
		$this->template->content->professors = $professors;
		$this->template->content->db_size = $db_size;
		$this->template->content->total_users = $users - 3; # to account for the admin and test users
		$this->template->content->student_users = $student_users - 1;
		$this->template->content->professor_users = $professor_users - 1;
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
		$body = "Dear ".$professor['first_name'].",<br><br>Thank you so much for your patience while we validated your identity. You can now head to our <a href='http://www.virska.com/users/validate'>validation page</a> with the validation code '".$professor['val_code']."' to unlock Virska.<br><br>Thanks!<br><br>The Virska Verification Team";

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
	
	public function p_idod_growth() {
		
		# Build the last weeks' user counts
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y")."'";
		
		$today = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-1 day'))."'";
		
		$day_1 = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-2 days'))."'";
		
		$day_2 = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-3 days'))."'";
		
		$day_3 = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-4 days'))."'";
		
		$day_4 = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-5 days'))."'";
		
		$day_5 = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-6 days'))."'";
		
		$day_6 = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created = '".date("d-M-Y", strtotime('-7 days'))."'";
		
		$day_7 = DB::instance(DB_NAME)->select_field($q);
		
		$data = array();
		$data['values'] = array($today, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $day_7);
		$data['days'] = array(
							date("d-M-y"),
							date("d-M-y", strtotime('-1 day')), 
							date("d-M-y", strtotime('-2 days')),			
							date("d-M-y", strtotime('-3 days')),
							date("d-M-y", strtotime('-4 days')),
							date("d-M-y", strtotime('-5 days')),
							date("d-M-y", strtotime('-6 days')),
							date("d-M-y", strtotime('-7 days')));
			
		echo json_encode($data);
	}

	public function p_adod_growth() {
		
		# what are the "extra" users that shouldn't be counted
		$extras = 3; # admin, test users
		
		# Build the last weeks' user counts
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y")."'";

		$today = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-1 day'))."'";
		
		$day_1 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-2 days'))."'";
		
		$day_2 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-3 days'))."'";
		
		$day_3 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-4 days'))."'";
		
		$day_4 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-5 days'))."'";
		
		$day_5 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-6 days'))."'";
		
		$day_6 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$q = "SELECT
		COUNT(user_id)
		FROM users
		WHERE created BETWEEN '01-Jan-2013' AND '".date("d-M-Y", strtotime('-7 days'))."'";
		
		$day_7 = DB::instance(DB_NAME)->select_field($q) - $extras;
		
		$data = array();
		$data['values'] = array($today, $day_1, $day_2, $day_3, $day_4, $day_5, $day_6, $day_7);
		$data['days'] = array(
							date("d-M-y"),
							date("d-M-y", strtotime('-1 day')), 
							date("d-M-y", strtotime('-2 days')),			
							date("d-M-y", strtotime('-3 days')),
							date("d-M-y", strtotime('-4 days')),
							date("d-M-y", strtotime('-5 days')),
							date("d-M-y", strtotime('-6 days')),
							date("d-M-y", strtotime('-7 days')));
			
		echo json_encode($data);
	}
} // end class
?>