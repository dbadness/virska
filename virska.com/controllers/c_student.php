<?php
	
	class student_controller extends base_controller {
		
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
			$this->template->content = View::instance('v_index_nav_student');
			$this->template->content .= View::instance('v_student_profile');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
		}
	}

?>