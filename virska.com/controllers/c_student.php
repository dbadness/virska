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
								"/css/student.css"
		                    );

		    $this->template->client_files = Utils::load_client_files($client_files);
				
		}
		
		public function index() {
			Router::redirect("/");
		}
		
		public function dashboard() {
			
			# We'll need classes and sections for our loops in the view for the "sectionView" div
			$q = "SELECT sections.*, classes.class_name, classes.class_code
			FROM sections
			JOIN classes
			USING (class_id)";
			
			$sections = DB::instance(DB_NAME)->select_rows($q);		
			
			# We'll also grab the sections they're following so they can unfollow if they need to
			$q = "SELECT *
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;

			$follows = DB::instance(DB_NAME)->select_rows($q);
			
			# Build a query of the professors this user is following - we're only interested in their sections
			$q = "SELECT * 
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

			# Run our query, store the results in the variable $sections
			$q =
			"SELECT sections.*, classes.class_name, classes.class_code
			FROM sections 
			JOIN classes USING (class_id) 
			WHERE sections.section_id IN (".$connections_string.")";
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# The user's main dashboard in Virska
			$this->template->content = View::instance('v_student_dashboard');
			$this->template->title = "Dashboard for ".$this->user->first_name." ".$this->user->last_name;
			$this->template->content->sections = $sections;
			
			echo $this->template;
		}
		
		public function sections() {
			
			# Sets up array of followed sections so we can pull data from it for the assignments, syllabi, and schedule views
			$q = "SELECT *
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;
			
			$sections_followed = DB::instance(DB_NAME)->select_array($q, 'section_id_followed');
		}
		
		public function assignments() {
			
			# Lists the assignments that student is following
				
		}
		
		public function syllabus() {
			
			# Lists individual classes inside a section so the student knows what's happening that day
		}
		
		public function notes() {
			
			# Dashboard for viewing notes
			$q = "SELECT *
			FROM notes
			WHERE user_id = ".$this->user->user_id;
			
			$notes = DB::instance(DB_NAME)->select_rows($q);
			
			# Build a query of the professors this user is following - we're only interested in their sections
			$q = "SELECT * 
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

			# Run our query, store the results in the variable $sections
			$q =
			"SELECT sections.*, classes.class_name, classes.class_code
			FROM sections 
			JOIN classes USING (class_id) 
			WHERE sections.section_id IN (".$connections_string.")";
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# Set up our view
			$this->template->content = View::instance('v_student_notes');
			
			# Pass our queried data to the view
			$this->template->content->notes = $notes;
			$this->template->content->sections = $sections;
		
			echo $this->template;
		}
		
		public function notes_new() {
			
			# Sets up array of followed sections so we can pull data from it for the assignments, syllabi, and schedule views
			# Build a query of the professors this user is following - we're only interested in their sections
			$q = "SELECT * 
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

			# Run our query, store the results in the variable $sections
			$q =
			"SELECT sections.*, classes.class_name, classes.class_code
			FROM sections 
			JOIN classes USING (class_id) 
			WHERE sections.section_id IN (".$connections_string.")";

			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_student_notes_new");
			$this->template->content->sections = $sections;
		
			echo $this->template;
		}
		
		public function notes_edit($note_id) {
			
			# Find the note they're editing
			$q = "SELECT *
			FROM notes
			WHERE note_id = ".$note_id;
			
			$note = DB::instance(DB_NAME)->select_row($q);
			
			$q = "SELECT sections.section_name, classes.class_name, classes.class_code
			FROM sections
			JOIN classes
			USING (class_id)
			WHERE section_id = ".$note['section_id'];
			
			$section = DB::instance(DB_NAME)->select_row($q);
			
			# Make sure they can't edit other people's notes
			if($this->user->user_id != $note['user_id']) {
				Router::redirect("/student/notes");
			}	
			
			# Dashboard for editing existing notes
			$this->template->content = View::instance('v_student_notes_edit');
			
			# Pass the note to the view
			$this->template->content->note = $note;
			$this->template->content->section = $section;
		
			echo $this->template;
		}
		
		public function p_add_note() {
			
			# Dashboard for taking notes
			
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now();
			$_POST['modified'] = Time::now();
			
			DB::instance(DB_NAME)->insert('notes', $_POST);
			
			Router::redirect("/student/notes");
			
		}
		
		public function p_edit_note() {
			
			# Function to update an edited note
			$_POST['user_id'] = $this->user->user_id;
			$_POST['modified'] = Time::now();
			
			$data = Array('title' => $_POST['title'], 'content' => $_POST['content'], 'modified' => $_POST['modified'], 'user_id' => $_POST['user_id']);
			DB::instance(DB_NAME)->update("notes", $data, "WHERE note_id = '".$_POST['note_id']."'");
			
			Router::redirect("/student/notes");
			
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
			$q = "SELECT *
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;

			$follows = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_student_search_results");		
			$this->template->title = "Professors at ".$this->user->school;
			$this->template->content->professors = $professors;
			$this->template->content->sections = $sections;
			$this->template->content->follows = $follows;
			
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
			$q = "SELECT *
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;

			$follows = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_student_search_results");		
			$this->template->title = "Professors at ".$this->user->school;
			$this->template->content->professors = $professors;
			$this->template->content->sections = $sections;
			$this->template->content->follows = $follows;
			
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
	
		public function schedule() {
			
			# Displays what sections the student is following and when and where the classes are
		}
		
		public function settings() {
				
			# Setup view
			$this->template->content = View::instance('v_student_settings');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
		}
		
	}

?>