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
				
		}
		
		public function index() {
			Router::redirect("/");
		}

		public function profile() {
				
			# Setup view
			$this->template->content = View::instance('v_student_profile');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
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
		
			$this->template->content = View::instance('v_student_notes');
		
			$this->template->content->notes = $notes;
		
			echo $this->template;
		}
		
		public function notes_new() {
			
			# Sets up array of followed sections so we can pull data from it for the assignments, syllabi, and schedule views
			$q = "SELECT *
			FROM sections_followed
			WHERE user_id = ".$this->user->user_id;
			
			$sections_followed = DB::instance(DB_NAME)->select_array($q, 'section_id_followed');
			
			# Pass the data to the view
			$this->template->content = View::instance('v_student_notes_new');	
			$this->template->content->sections_followed = $sections_followed;
		
			echo $this->template;
		}
		
		public function notes_edit() {
			
			# Dashboard for taking notes
			$this->template->content = View::instance('v_student_notes/edit');	
			$this->template->content->sections_followed = $sections_followed;
		
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
		
		public function search() {
			
			$this->template->content = View::instance('v_student_search');
			echo $this->template; 
		}
		
		public function search_results() {
			
			# Allows the student to search for professors to follow
			$q = "SELECT *
			FROM users
			WHERE role = 'professor'
			AND school = '".$this->user->school."'
			AND last_name = '".$_POST['search']."'";
			
			$professors = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_student_search_results");
			$this->template->content->professors = $professors;
			echo $this->template; 
		}	
	
		public function schedule() {
			
			# Displays what sections the student is following and when and where the classes are
		}
		
	}

?>