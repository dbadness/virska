<?php
	
	class student_controller extends base_controller {
		
		public function __construct() {
			parent::__construct();
			
			# If user is blank, they're not logged in, show message and don't do anything else
			if(!$this->user) {
				Router::redirect("/users/login");
				# Return will force this method to exit here so the rest of 
				# the code won't be executed and the profile view won't be displayed.
				return false;
			}
			
			# Make sure that they're a student and if not redirect them back to login
			if($this->user->role == 'professor') {
				Router::redirect("/");
			}
			
			# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
								"/js/student.js",
								"/css/student.css",
								"http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"
								 );

		    $this->template->client_files = Utils::load_client_files($client_files);
				
		}
		
		public function index() {
			Router::redirect("/");
		}
		
		public function dashboard() {
			
			# Build a query of the professors this user is following - we're only interested in their sections
			$q = "SELECT section_id_followed 
				FROM sections_followed
				WHERE user_id = ".$this->user->user_id;

			# Execute our query, storing the results in a variable $connections
			$connections = DB::instance(DB_NAME)->select_rows($q);

			# In order to query for the sections we need, we're going to need a string of section id's, separated by commas
			# To create this, loop through our connections array
			$connections_string = "";
			foreach($connections as $connection) {
				$connections_string .= $connection['section_id_followed'].",";
			}

			# Remove the final comma 
			$connections_string = substr($connections_string, 0, -1);

			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, classes.class_name, classes.class_code
				FROM sections 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")";
			}
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# Let's find the events that are happening today to start our page off right
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date = '".date("m/d/Y")."'";
				# remember to surround the dates in single quotes because they're strings in mysql
			}
			
			$todays_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date BETWEEN '".date("m/d/y")."' AND '".date("m/d/y", strtotime('+7 days'))."'
				ORDER BY date ASC";
				# we can use the string to time function to return the events happening in the next week
			}
			
			$weeks_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT event_id, modified
				FROM submissions
				WHERE section_id IN (".$connections_string.")
				AND user_id = ".$this->user->user_id;
			}
			
			$submissions = DB::instance(DB_NAME)->select_array($q, 'event_id');
			
			# Select all of the unread messages that belong to this student
			$q = "SELECT *
			FROM messages
			WHERE user_id = ".$this->user->user_id."
			AND unread = 1";
			
			$unread_messages = DB::instance(DB_NAME)->select_rows($q);
			
			# The user's main dashboard in Virska
			$this->template->content = View::instance('v_student_dashboard');
			$this->template->title = "Dashboard for ".$this->user->first_name." ".$this->user->last_name;
			$this->template->content->sections = $sections;
			$this->template->content->todays_events = $todays_events;
			$this->template->content->weeks_events = $weeks_events;
			$this->template->content->submissions = $submissions;
			$this->template->content->unread_messages = $unread_messages;
			
			echo $this->template;
		}
		
		public function messages() {
			
			# Select all of the read messages that belong to this student
			$q = "SELECT *
			FROM messages
			WHERE user_id = ".$this->user->user_id."
			AND unread = 0";
			
			$read_messages = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_student_messages");
			
			$this->template->content->read_messages = $read_messages;
			
			echo $this->template;
			
		}
		
		public function p_read() {
			
			$data = Array('unread' => 0);
			
			DB::instance(DB_NAME)->update("messages", $data, "WHERE message_id = '".$_POST['message_id']."'");
			
			Router::redirect("/student/dashboard");
			
		}
		
		public function p_unread() {
			
			$data = Array('unread' => 1);
			
			DB::instance(DB_NAME)->update("messages", $data, "WHERE message_id = '".$_POST['message_id']."'");
			
			Router::redirect("/student/messages");
		}
		
		public function p_delete_message() {
			
			# Delete this message forever
			$where_condition = 'WHERE message_id = '.$_POST['message_id'];
			DB::instance(DB_NAME)->delete('messages', $where_condition);
			
			Router::redirect("/student/messages");
		}
		
		public function grades($section_id) {
			
			$q = "SELECT sections.*, classes.class_code
			FROM sections
			JOIN classes USING (class_id)
			WHERE section_id = ".$section_id;
			
			$section = DB::instance(DB_NAME)->select_row($q);
			
			$q = "SELECT *
			FROM submissions
			WHERE section_id = ".$section_id."
			AND user_id = ".$this->user->user_id;
			
			$submissions = DB::instance(DB_NAME)->select_rows($q);

			$this->template->content = View::instance('v_student_grades');
			$this->template->title = "Grades for ".$this->user->first_name." ".$this->user->last_name." in ".$section['class_code'];
			$this->template->content->section = $section;
			$this->template->content->submissions = $submissions;
			
			# Render template
			echo $this->template;	
		}
		
		public function p_submit($event_id) {
			
			$_POST['created'] = Time::now();
			$_POST['modified'] = Time::now();
			$_POST['user_id'] = $this->user->user_id;
			$_POST['doc'] = $_POST['modified']."-".$_FILES['doc']['name']; 
			# in case the student modifies their submission, let's rewrite the existing file in the docs folder
			$_POST['event_id'] = $event_id;
			
			$filetypes = array(
				'doc',
				'docx',
				'ppt',
				'pptx',
				'xls',
				'xlsx',
				'pages',
				'numbers',
				'keynote',
				'pdf'
			);
			
			if(!in_array(pathinfo($_FILES['doc']['name'])['extension'], $filetypes)) {
				
				$error = 1;
				
				Router::redirect("/student/submission_error");
				
			}
			
			$value = strlen(pathinfo($_FILES['doc']['name'])['extension']) + 1;
		
			$new_val = 0 - $value;

			Upload::upload($_FILES, "/docs/", $filetypes, substr($_POST['doc'], 0, $new_val));
			
			DB::instance(DB_NAME)->insert('submissions', $_POST);
			
			Router::redirect("/student/dashboard");
		}
		
		public function p_resubmit($event_id) {
			
			$_POST['modified'] = Time::now();
			$_POST['doc'] = $_POST['modified']."-".$_FILES['doc']['name'];
			
			$data = Array('modified' => $_POST['modified'], 'doc' => $_POST['doc']);
			
			$filetypes = array(
				'doc',
				'docx',
				'ppt',
				'pptx',
				'xls',
				'xlsx',
				'pages',
				'numbers',
				'keynote',
				'pdf'
			);
			
			if(!in_array(pathinfo($_FILES['doc']['name'])['extension'], $filetypes)) {
				
				$error = 1;
				
				Router::redirect("/student/submission_error");
				
			}
			
			$value = strlen(pathinfo($_FILES['doc']['name'])['extension']) + 1;
		
			$new_val = 0 - $value;

			Upload::upload($_FILES, "/docs/", $filetypes, substr($_POST['doc'], 0, $new_val));
			
			DB::instance(DB_NAME)->update("submissions", $data, "WHERE event_id = '".$event_id."' AND user_id = '".$this->user->user_id."'");
			
			Router::redirect("/student/dashboard");
		}

		public function dashboard_results() {
			
			if(!$_POST) {
				Router::redirect("/student/dashboard");
			}
			
			# Build a query of the professors this user is following - we're only interested in their sections
			$q = "SELECT section_id_followed 
				FROM sections_followed
				WHERE user_id = ".$this->user->user_id;

			# Execute our query, storing the results in a variable $connections
			$connections = DB::instance(DB_NAME)->select_rows($q);

			# In order to query for the sections we need, we're going to need a string of section id's, separated by commas
			# To create this, loop through our connections array
			$connections_string = "";
			foreach($connections as $connection) {
				$connections_string .= $connection['section_id_followed'].",";
			}

			# Remove the final comma 
			$connections_string = substr($connections_string, 0, -1);

			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, classes.class_name, classes.class_code
				FROM sections 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")";
			}
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# Let's find the events that are happening today to start our page off right
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date = '".date("m/d/Y")."'";
				# remember to surround the dates in single quotes because they're strings in mysql
			}
			
			$todays_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date BETWEEN '".date("m/d/y")."' AND '".date("m/d/y", strtotime('+7 days'))."'
				ORDER BY date ASC";
				# we can use the string to time function to return the events happening in the next week
			}
			
			$weeks_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT event_id, modified
				FROM submissions
				WHERE section_id IN (".$connections_string.")
				AND user_id = ".$this->user->user_id;
			}
			
			$submissions = DB::instance(DB_NAME)->select_array($q, 'event_id');
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date = '".$_POST['date']."'";
			}
			
			$searched_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Select all of the messages that belong to this student
			$q = "SELECT *
			FROM messages
			WHERE user_id = ".$this->user->user_id."
			AND unread = 1";
			
			$unread_messages = DB::instance(DB_NAME)->select_rows($q);
			
			# Select all of the messages that belong to this student
			$q = "SELECT *
			FROM messages
			WHERE user_id = ".$this->user->user_id."
			AND unread = 0";
			
			$read_messages = DB::instance(DB_NAME)->select_rows($q);
			
			$date = $_POST['date'];
			
			# The user's main dashboard in Virska
			$this->template->content = View::instance('v_student_dashboard_results');
			$this->template->title = "Dashboard for ".$this->user->first_name." ".$this->user->last_name;
			$this->template->content->sections = $sections;
			$this->template->content->todays_events = $todays_events;
			$this->template->content->weeks_events = $weeks_events;
			$this->template->content->searched_events = $searched_events;
			$this->template->content->submissions = $submissions;
			$this->template->content->date = $date;
			$this->template->content->unread_messages = $unread_messages;
			$this->template->content->read_messages = $read_messages;
			
			echo $this->template;
			
		}
		
		public function submission_error() /* If making changes to student dashbaord, please look here as well. */ { 
			
			# Build a query of the professors this user is following - we're only interested in their sections
			$q = "SELECT section_id_followed 
				FROM sections_followed
				WHERE user_id = ".$this->user->user_id;

			# Execute our query, storing the results in a variable $connections
			$connections = DB::instance(DB_NAME)->select_rows($q);

			# In order to query for the sections we need, we're going to need a string of section id's, separated by commas
			# To create this, loop through our connections array
			$connections_string = "";
			foreach($connections as $connection) {
				$connections_string .= $connection['section_id_followed'].",";
			}

			# Remove the final comma 
			$connections_string = substr($connections_string, 0, -1);

			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, classes.class_name, classes.class_code
				FROM sections 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")";
			}
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# Let's find the events that are happening today to start our page off right
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date = '".date("m/d/Y")."'";
				# remember to surround the dates in single quotes because they're strings in mysql
			}
			
			$todays_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT sections.*, events.*, classes.class_code
				FROM sections 
				JOIN events USING (section_id) 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")
				AND date BETWEEN '".date("m/d/y")."' AND '".date("m/d/y", strtotime('+7 days'))."'
				ORDER BY date ASC";
				# we can use the string to time function to return the events happening in the next week
			}
			
			$weeks_events = DB::instance(DB_NAME)->select_rows($q);
			
			# Run our query, store the results in the variable $sections (if they're following sections...)
			if($connections_string) {
				
				$q =
				"SELECT event_id, modified
				FROM submissions
				WHERE section_id IN (".$connections_string.")
				AND user_id = ".$this->user->user_id;
			}
			
			$submissions = DB::instance(DB_NAME)->select_array($q, 'event_id');
			
			# Select all of the unread messages that belong to this student
			$q = "SELECT *
			FROM messages
			WHERE user_id = ".$this->user->user_id."
			AND unread = 1";
			
			$unread_messages = DB::instance(DB_NAME)->select_rows($q);
			
			#Here's the error to let the student know that their filetype is not supported
			$error = 1;
			
			# The user's main dashboard in Virska
			$this->template->content = View::instance('v_student_dashboard');
			$this->template->title = "Dashboard for ".$this->user->first_name." ".$this->user->last_name;
			$this->template->content->sections = $sections;
			$this->template->content->todays_events = $todays_events;
			$this->template->content->weeks_events = $weeks_events;
			$this->template->content->submissions = $submissions;
			$this->template->content->error = $error;
			$this->template->content->unread_messages = $unread_messages;
			
			echo $this->template;
			
		}
		
		public function search() {
			
			$this->template->content = View::instance('v_student_search');
			echo $this->template; 
		}
		
		# note that "search_results" and "professor_list" are very similar. If changing code in one, please review the other
		public function search_results() {
			
			# Allows the student to search for professors to follow
			$q = "SELECT *
			FROM users
			WHERE role = 'professor'
			AND school = '".$this->user->school."'
			AND last_name = '".$_POST['search']."'";
			
			$professors = DB::instance(DB_NAME)->select_rows($q);
			
			# We'll also need classes and sections for our loops in the view
			$q = "SELECT sections.*, classes.class_name, classes.class_code
			FROM sections
			JOIN classes
			USING (class_id)";
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# We'll also grab the sections they're followeing so they can unfollow if they need to
			$q = "SELECT section_id_followed
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;

			$connections = DB::instance(DB_NAME)->select_array($q, 'section_id_followed');
			
			$this->template->content = View::instance("v_student_search_results");		
			$this->template->title = "Professors at ".$this->user->school;
			$this->template->content->professors = $professors;
			$this->template->content->sections = $sections;
			$this->template->content->connections = $connections;
			
			echo $this->template;
		}	
		
		public function professor_list() {
			
			# Find all of the professors in the user's school and return them as a list in alphebetical order by last name
			$q = "SELECT *
			FROM users
			WHERE role = 'professor'
			AND school = '".$this->user->school."'
			ORDER BY last_name";
			
			$professors = DB::instance(DB_NAME)->select_rows($q);
			
			# We'll also need classes and sections for our loops in the view
			$q = "SELECT sections.*, classes.class_name, classes.class_code
			FROM sections
			JOIN classes
			USING (class_id)";
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# We'll also grab the sections they're followeing so they can unfollow if they need to
			$q = "SELECT section_id_followed
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;

			$connections = DB::instance(DB_NAME)->select_array($q, 'section_id_followed');
			
			$this->template->content = View::instance("v_student_search_results");		
			$this->template->title = "Professors at ".$this->user->school;
			$this->template->content->professors = $professors;
			$this->template->content->sections = $sections;
			$this->template->content->connections = $connections;
			
			echo $this->template;			
		}
		
		public function p_follow($section_id) {
			
			# This function takes the section_id from search results and links that section to the user
			# Get information and put it into an array "$section_followed"
			$section_followed = Array (
								"user_id" => $this->user->user_id,
								"section_id_followed" => $section_id,
								"created" => Time::now(),
								"modified" => Time::now()
							);

			#insert data into the database
			DB::instance(DB_NAME)->insert('sections_followed', $section_followed);
			
			# Send them back to their dashboard
			Router::redirect("/student/dashboard");
			
		}
		
		public function p_unfollow($section_id) {

			# Delete this connection
			$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND section_id_followed = '.$section_id;
			DB::instance(DB_NAME)->delete('sections_followed', $where_condition);

			# Send them back to the dashboard
			Router::redirect("/student/dashboard");

		}
	
		public function settings() {
			
			if($this->user->carrier == "@txt.att.net") {
				$carrier = "AT&T";
			} elseif($this->user->carrier == "@vtext.com") {
				$carrier = "Verizon";
			} elseif($this->user->carrier == "@tmomail.net") {
				$carrier = "T-Mobile";
			} elseif($this->user->carrier == "@messaging.sprintpcs.com") {
				$carrier = "Sprint";
			}
				
			# Setup view
			$this->template->content = View::instance('v_student_settings');
			$this->template->title = "Profile of ".$this->user->first_name;
			$this->template->content->carrier = $carrier;

			# Render template
			echo $this->template;
		}
	
		public function p_update_contact() {
				
			$data = Array('email' => $_POST['email'], 'mobile' => $_POST['mobile'], 'carrier' => $_POST['carrier']);
			
			DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");
			
			Router::redirect("/student/settings");
		}
		
		public function p_update_prefs() {
			
			$data = Array('receive_email' => $_POST['receive_email'], 'receive_text' => $_POST['receive_text']);

			DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = '".$this->user->user_id."'");
			
			Router::redirect("/student/update_success");	
		}	
		
		public function update_success() {
			
			if($this->user->carrier == "@txt.att.net") {
				$carrier = "AT&T";
			} elseif($this->user->carrier == "@vtext.com") {
				$carrier = "Verizon";
			} elseif($this->user->carrier == "@tmomail.net") {
				$carrier = "T-Mobile";
			} elseif($this->user->carrier == "@messaging.sprintpcs.com") {
				$carrier = "Sprint";
			}
			
			$this->template->content = View::instance("v_student_settings");
			$this->template->content->contact_updated = 1;
			$this->template->content->carrier = $carrier;
			
			echo $this->template;
		}
		
	}

?>