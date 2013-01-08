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
			
			$fname = $this->user->first_name;
			$lname = $this->user->last_name;
			
			# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
								"/js/student.js",
								"/css/student.css",
								"http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css"
								 );

		    $this->template->client_files = Utils::load_client_files($client_files);
			
			# The user's main dashboard in Virska
			$this->template->content = View::instance('v_student_dashboard');
			$this->template->title = "Dashboard for ".$this->user->first_name." ".$this->user->last_name;
			$this->template->content->sections = $sections;
			$this->template->content->todays_events = $todays_events;
			$this->template->content->weeks_events = $weeks_events;
			$this->template->content->submissions = $submissions;
			$this->template->content->fname = $fname;
			$this->template->content->lname = $lname;
			
			echo $this->template;
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
		
		public function p_submit($event_id, $event_desc) {
			
			$_POST['created'] = Time::now();
			$_POST['modified'] = Time::now();
			$_POST['user_id'] = $this->user->user_id;
			$_POST['doc'] = $_POST['modified']."-".$_FILES['submission']['name']; 
			# in case the student modifies their submission, let's rewrite the existing file in the docs folder
			$_POST['event_id'] = $event_id;
			
			Upload::upload($_FILES, "/docs/", array("pdf", "doc", "xls", "ppt"), substr($_POST['doc'], 0, -4));
			
			DB::instance(DB_NAME)->insert('submissions', $_POST);
			
			Router::redirect("/student/dashboard");
		}
		
		public function p_resubmit ($event_id) {
			
			$_POST['modified'] = Time::now();
			$_POST['doc'] = $_POST['modified']."-".$_FILES['submission']['name'];
			
			$data = Array('modified' => $_POST['modified'], 'doc' => $_POST['doc']);
			
			Upload::upload($_FILES, "/docs/", array("pdf", "doc", "xls", "ppt"), substr($_POST['doc'], 0, -4));
			
			DB::instance(DB_NAME)->update("submissions", $data, "WHERE event_id = '".$event_id."' AND user_id = '".$this->user->user_id."'");
			
			Router::redirect("/student/dashboard");
		}

		public function dashboard_results() {
			
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
			
			$fname = $this->user->first_name;
			$lname = $this->user->last_name;
			
			$date = $_POST['date'];
			
			# The user's main dashboard in Virska
			$this->template->content = View::instance('v_student_dashboard_results');
			$this->template->title = "Dashboard for ".$this->user->first_name." ".$this->user->last_name;
			$this->template->content->sections = $sections;
			$this->template->content->todays_events = $todays_events;
			$this->template->content->weeks_events = $weeks_events;
			$this->template->content->searched_events = $searched_events;
			$this->template->content->submissions = $submissions;
			$this->template->content->fname = $fname;
			$this->template->content->lname = $lname;
			$this->template->content->date = $date;
			
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
		
		public function professor_list () {
			
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
				
			# Setup view
			$this->template->content = View::instance('v_student_settings');
			$this->template->title = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
		}
		
	}

?>