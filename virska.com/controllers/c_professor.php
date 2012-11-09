<?php
	
	class professor_controller extends base_controller {
		
		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			Router::redirect("/");
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
			$this->template->content = View::instance('v_index_nav_professor');
			$this->template->content .= View::instance('v_professor_profile');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
		}
		
		public function add_class() {
			
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
			$this->template->content = View::instance('v_professor_add_class');
			$this->template->title   = "Profile of ".$this->user->first_name;
			
			# Pass data to view			
			$this->template->content->classes = $classes;
			$this->template->content->sections = $sections;

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
			
			Router::redirect("/professor/add_class");
		}
		
		public function p_add_section() {
			
			# Build query to add the class to the table "Sections"
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now(); # this returns the current time
			$_POST['modified'] = Time::now(); # this returns the current time
			

			#insert data into the database
			DB::instance(DB_NAME)->insert('sections', $_POST);
			
			Router::redirect("/professor/add_class");
		}
	}

?>