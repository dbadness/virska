<?php
	
	class student_controller extends base_controller {
		
		public function __construct() {
			parent::__construct();
			
			# Make sure that they're a student and if not redirect them back to login
			if($this->user->role == 'professor') {
				Router::redirect("/");
			}
				
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
			$this->template->content = View::instance('v_student_profile');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
		}
		
		public function assignments() {
			
			# Lists the assignments that student is following
		}
		
		public function syllabus() {
			
			# Lists individual classes inside a section so the student knows what's happening that day
		}
		
		public function notes() {
			
			# Dashboard for taking notes
		}
		
		public function search() {
			
			# Allows the student to search for professors to follow
		}		
	
		public function schedule() {
			
			# Displays what sections the student is following and when and where the classes are
		}
		
	}

?>