<?php
	
	class forums_controller extends base_controller {

		public function __construct() {
			parent::__construct();
	
			# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						"/css/forum.css",
						"/js/forum.js",
						"/js/autogrow.js"
	                    );

		    $this->template->client_files = Utils::load_client_files($client_files);
		}

		public function index() {
			# The following is a just a copy and paste job so we can get the sections the user if following.
			
			if($this->user->role == 'student') {
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
				
			} elseif($this->user->role == 'professor') {
				
				# create a query to gather all the sections this professor has created
				$q = "SELECT *
				FROM sections
				JOIN classes USING (class_id)
				WHERE sections.user_id = ".$this->user->user_id;
				
				$sections = DB::instance(DB_NAME)->select_rows($q);
				
			}
			
			$this->template->content = View::instance("v_forums_index");
			$this->template->content->sections = $sections;
			$this->template->title = "Forums";
			echo $this->template;
			
		}

		public function add($section_id) {
			
			$q = "SELECT *
			FROM sections
			JOIN classes USING (class_id)
			WHERE section_id = ".$section_id;
			
			$section = DB::instance(DB_NAME)->select_row($q);
			
			$this->template->content = View::instance("v_forums_add");
			$this->template->content->section = $section;
			
			echo $this->template;
			
		}
		
		public function view_section($section_id) {
			
			$q = "SELECT *
			FROM sections
			JOIN classes USING (class_id)
			WHERE section_id = ".$section_id;
			
			$section = DB::instance(DB_NAME)->select_row($q);
			
			$q = "SELECT *
			FROM threads
			WHERE section_id = ".$section_id;
			
			$threads = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_forums_view_section");
			$this->template->content->section = $section;
			$this->template->content->threads = $threads;
			
			echo $this->template;
			
		}
		
		public function view_thread($thread_id) {
			
			#grab information about this thread so we can pass it on to the view
			$q = "SELECT *
			FROM threads
			WHERE thread_id = ".$thread_id;
			
			$thread = DB::instance(DB_NAME)->select_row($q);
			
			# now let's collect all of the comments for that thread
			$q = "SELECT comments.*, users.first_name, users.last_name
			FROM comments
			JOIN users USING (user_id)
			WHERE thread_id = '".$thread_id."'
			ORDER BY comments.created ASC";
			
			$comments = DB::instance(DB_NAME)->select_rows($q);
			
			$this->template->content = View::instance("v_forums_view_thread");
			$this->template->title = $thread['title'];
			$this->template->content->thread = $thread;
			$this->template->content->comments = $comments;
			
			echo $this->template;
			
		}
		
		public function p_add_thread() {
			
			$_POST['created'] = Time::now();
			$_POST['user_id'] = $this->user->user_id;
			
			$thread_info = array(
				'created' => $_POST['created'],
				'title' => $_POST['title'],
				'user_id' => $this->user->user_id,
				'section_id' => $_POST['section_id']
			);
			
			# insert the thread information into the thread table
			DB::instance(DB_NAME)->insert('threads', $thread_info);
			
			$q = "SELECT *
			FROM threads
			WHERE user_id = '".$this->user->user_id."'
			ORDER BY created DESC
			LIMIT 1";
			
			$thread = DB::instance(DB_NAME)->select_row($q);
			
			$comment_info = array(
				'created' => $_POST['created'],
				'comment' => $_POST['comment'],
				'user_id' => $this->user->user_id,
				'thread_id' => $thread['thread_id'],
				'section_id' => $_POST['section_id']
			);
			
			# insert the thread information into the thread table
			DB::instance(DB_NAME)->insert('comments', $comment_info);
			
			Router::redirect("/forums/view_thread/".$thread['thread_id']);
					
		}
	
		public function p_add_comment() {
			
			$_POST['created'] = Time::now();
			
			DB::instance(DB_NAME)->insert('comments', $_POST);
			
			Router::redirect("/forums/view_thread/".$_POST['thread_id']);
			
		}
	
		public function p_delete_comment($comment_id, $thread_id) {
			
			DB::instance(DB_NAME)->delete('comments', "WHERE comment_id = ".$comment_id);
			
			Router::redirect("/forums/view_thread/".$thread_id);
			
		}
	
	}
?>
