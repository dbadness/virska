<?php
	
	class notes_controller extends base_controller {
		
		public function __construct() {
			parent::__construct();
			
			if(!$this->user){
				Router::redirect("/users/login");
			}
		}
		
		public function index() {
			
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

			if($connections_string) {
				# Run our query, store the results in the variable $sections
				$q =
				"SELECT sections.*, classes.class_name, classes.class_code
				FROM sections 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")";
			}
			
			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			# Set up our view
			$this->template->content = View::instance('v_notes_index');
			
			$client_files = Array(
						"/css/note.css",
						"/js/note.js"
						);

		    $this->template->client_files = Utils::load_client_files($client_files);
			
			# Pass our queried data to the view
			$this->template->content->notes = $notes;
			$this->template->title = "Notes";
			$this->template->content->sections = $sections;
		
			echo $this->template;
		}
		
		public function add() {
			
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

			# Run our query, store the results in the variable $sections if they're following any
			if($connections_string) {	
				$q =
				"SELECT sections.*, classes.class_name, classes.class_code
				FROM sections 
				JOIN classes USING (class_id) 
				WHERE sections.section_id IN (".$connections_string.")";
			}

			$sections = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_notes_add");
			
			$client_files = Array(
						"/css/note.css",
						"http://js.nicedit.com/nicEdit-latest.js",
						"/js/note-new.js"
						);

		    $this->template->client_files = Utils::load_client_files($client_files);
			$this->template->content->sections = $sections;
			$this->template->title = "Notes";
		
			echo $this->template;
		}
		
		public function edit($note_id) {
			
			# Find the note they're editing
			$q = "SELECT *
			FROM notes
			WHERE note_id = ".$note_id;
			
			$note = DB::instance(DB_NAME)->select_row($q);
			
			# Make sure they can't edit other people's notes
			if($this->user->user_id != $note['user_id']) {
				Router::redirect("/notes/index");
			}	
			
			# Dashboard for editing existing notes
			$this->template->content = View::instance('v_notes_edit');
			
			$client_files = Array(
								"http://js.nicedit.com/nicEdit-latest.js",
								"/js/note-edit.js",
								"/css/note.css"
								 );

		    $this->template->client_files = Utils::load_client_files($client_files);
			
			# Pass the note to the view
			$this->template->content->note = $note;
			$this->template->title = "Notes";
		
			echo $this->template;
		}
		
		public function p_add_note() {
			
			# Dashboard for taking notes
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now();
			$_POST['modified'] = Time::now();
		
			DB::instance(DB_NAME)->insert('notes', $_POST);
		
			# Find the last note created (this note) and echo its ID for redirection
			$q = "SELECT created, note_id
			FROM notes 
			WHERE user_id = ".$this->user->user_id."
			ORDER BY created DESC LIMIT 1";
			$note_info = DB::instance(DB_NAME)->select_row($q);
		
			$note_id = $note_info['note_id'];
			
			echo $note_id; 
		}
		
		public function p_save_note () {
			
			sleep(2);

			# Put the current title and content into the database
			$_POST['modified'] = Time::now();

			# Do the update
			DB::instance(DB_NAME)->update("notes", $_POST, "WHERE note_id = '".$_POST['note_id']."'");			
				
			# Find out when this note was last updated
			$q = "SELECT modified 
			FROM notes 
			WHERE note_id = ".$_POST['note_id']."
			ORDER BY modified DESC LIMIT 1"; // you'll need to find a way to get the note_id from the page so we're positive we're updating the right note
			$update = Time::display(DB::instance(DB_NAME)->select_field($q));
			
			echo $update;
			
		}
		
		public function p_delete_note($note_id) {

			#Delete the note for them
			DB::instance(DB_NAME)->delete('notes', "WHERE note_id = ".$note_id);

			# Bring them to their notes page
			Router::redirect("/notes");
		}
		
		public function results() {

			# if they searched for a note, deliver it to them
			# look through the notes table for notes (from this user) that match their search parameters
			$q = "SELECT *
			FROM notes 
			WHERE content
			LIKE '%".$_POST['search']."%'
			AND user_id = ".$this->user->user_id;
		
			$results = DB::instance(DB_NAME)->select_rows($q);
			
			$client_files = Array(
								"http://js.nicedit.com/nicEdit-latest.js",
								"/js/note.js",
								"/css/note.css"
								 );

		    $this->template->client_files = Utils::load_client_files($client_files);
		
			$this->template->content = View::instance("v_notes_results");
			$this->template->content->results = $results;
			$this->template->title = "Notes containing '".$_POST['search']."' for ".$this->user->first_name." ".$this->user->last_name;
		
			echo $this->template;
				
		}
	}
?>
