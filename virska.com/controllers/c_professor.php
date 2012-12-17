<?php
	
	class professor_controller extends base_controller {
		
		public function __construct() {
			parent::__construct();
			
			# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						"/css/professor.css",
						"/js/professor.js",
						"http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css",
					    "http://code.jquery.com/jquery-1.8.2.js",
					    "http://code.jquery.com/ui/1.9.1/jquery-ui.js"
	                    );
	
		    $this->template->client_files = Utils::load_client_files($client_files);
			
			# Make sure the user is a professor
			if($this->user->role == 'student') {
				Router::redirect("/");
			}
		}
		
		public function index() {
			Router::redirect("/");
		}
		
		public function dashboard() {
			
			$this->template->content = View::instance("v_professor_dashboard");
			
			echo $this->template;
		}

		public function profile() {
				
			# If user is blank, they're not logged in, show message and don't do anything else
			if(!$this->user) {
				Router::redirect("/users/login");
				# Return will force this method to exit here so the rest of 
				# the code won't be executed and the profile view won't be displayed.
				return false;
			}

			# Setup view
			$this->template->content = View::instance('v_professor_profile');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
		}
		
		public function classes() {
			
			# If user is blank, they're not logged in, show message and don't do anything else
			if(!$this->user) {
				Router::redirect("/users/login");
				# Return will force this method to exit here so the rest of 
				# the code won't be executed and the profile view won't be displayed.
				return false;
			}
			
			# Create array to show classes that have already been created
			$q = "SELECT *
				FROM classes 
				WHERE user_id = ".$this->user->user_id;
				
			$classes = DB::instance(DB_NAME)->select_rows($q);
			
			$q = "SELECT *
				FROM sections 
				WHERE user_id = ".$this->user->user_id;
				
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# Set up view
			# $this->template->content = View::instance('v_index_nav_professor');
			$this->template->content = View::instance('v_professor_classes');
			$this->template->title   = "Profile of ".$this->user->first_name;
			
			# Pass data to view			
			$this->template->content->classes = $classes;
			$this->template->content->sections = $sections;
			
			# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						"/css/professor.css"
	                    );

	    	$this->template->client_files = Utils::load_client_files($client_files);

			# Render template
			echo $this->template;
		}
		
		public function p_add_class() {
			
			# Build query to add the class to the table "Classes"
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now(); # this returns the current time
			$_POST['modified'] = Time::now(); # this returns the current time
			

			#insert data into the database
			DB::instance(DB_NAME)->insert('classes', $_POST);
			
			Router::redirect("/professor/classes");
		}
		
		public function p_add_section() {
			
			# Build query to add the class to the table "Sections"
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now(); # this returns the current time
			$_POST['modified'] = Time::now(); # this returns the current time
			

			#insert data into the database
			DB::instance(DB_NAME)->insert('sections', $_POST);
			
			Router::redirect("/professor/classes");
		}
		
		public function section($section_id) {
			
			# Add a assignment or schedule event to the section
			# Find the section they want to view and append the classes table so we can have as much info as possible for variables
			$q = "SELECT *
			FROM sections
			JOIN classes
			WHERE sections.user_id = ".$this->user->user_id."
			AND section_id = ".$section_id;

			$section = DB::instance(DB_NAME)->select_row($q);
			
			#  Give the user the ability to find the assignments associated with the selected section
			$q = "SELECT *
				FROM assignments 
				WHERE user_id = ".$this->user->user_id." 
				AND section_id = ".$section_id;

			$assignments = DB::instance(DB_NAME)->select_rows($q);
						
			# Setup the view
			$this->template->content = View::instance('v_professor_section');
	
			# Pass data back to the view
			$this->template->content->section = $section;
			$this->template->content->assignments = $assignments;
			$this->template->title = $section['class_name'].", Section ".$section['section_name'];
	
			# Render the view
			echo $this->template;
		}
				
		public function p_upload_assignment() {
			
			# Allow the user to create an assignment
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now(); # this returns the current time
			$_POST['modified'] = Time::now(); # this returns the current time
			$_POST['doc'] = $this->user->user_id.$_POST['created'];

			Upload::upload($_FILES, "/docs/", array("pdf"), $_POST['doc']);

			#insert data into the database
			DB::instance(DB_NAME)->insert('assignments', $_POST);

			Router::redirect("/professor/section/".$_POST['section_id']);
		}
	}


?>