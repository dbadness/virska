<?php

	class documents_controller extends base_controller {

		public function __construct() {
			parent::__construct();
		
			$client_files = Array(
								"/js/document.js",
								"/css/document.css"
								 );

		    $this->template->client_files = Utils::load_client_files($client_files);

		}
	
		public function index() {
		
			$q = "SELECT *
			FROM documents
			WHERE user_id = ".$this->user->user_id;
		
			$docs = DB::instance(DB_NAME)->select_rows($q);
		
			$q = "SELECT SUM(size)
			FROM documents
			WHERE user_id = ".$this->user->user_id;
		
			$doc_size = DB::instance(DB_NAME)->select_field($q);
		
			$this->template->content = View::instance("v_documents_index");
			$this->template->content->docs = $docs;
			$this->template->content->doc_size = $doc_size;
			$this->template->title = $this->user->first_name." ".$this->user->last_name."'s Documents";
	
			echo $this->template;
		
		}
	
		public function p_upload_doc() {
	
			$q = "SELECT count(doc_name)
			FROM documents
			WHERE doc_name = '".$_FILES['doc']['name']."'
			AND user_id = ".$this->user->user_id;
		
			$sum = DB::instance(DB_NAME)->select_field($q);
			
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
		
			if(!in_array(pathinfo($_FILES['doc']['name'])['extension'], $filetypes)){
			
				# give them a file-type error because that format of file is not support for upload
				$error = 1;
				Router::redirect("/documents/upload_error/".$error);
				return false;
			} elseif($sum == 1) {
			
				# Make sure they're not overwriting an existing document with the same name
				$error = 2;
				Router::redirect("/documents/upload_error/".$error);
				return false;
			
			} else {
			
				$value = strlen(pathinfo($_FILES['doc']['name'])['extension']) + 1;
			
				$new_val = 0 - $value;
			
				# let's find out how many characters we need to chop off of the extension
				if($_FILES['doc'])
		
				# If they're not, allow them to upload their document
				# Set up the $_POST array so the user can upload their document effectively
				$_POST['user_id'] = $this->user->user_id;
				$_POST['created'] = Time::now(); # this returns the current time
				$_POST['size'] = $_FILES['doc']['size'];
				$_POST['doc_name'] = $_FILES['doc']['name'];
				$_POST['doc_code'] = $this->user->user_id."-".$_FILES['doc']['name'];

				Upload::upload($_FILES, "/docs/", $filetypes, substr($_POST['doc_code'], 0, $new_val));

				#insert data into the database
				DB::instance(DB_NAME)->insert('documents', $_POST);

				Router::redirect("/documents");
			}
		}
	
		public function upload_error($error) {
		
			$q = "SELECT *
			FROM documents
			WHERE user_id = ".$this->user->user_id;
		
			$docs = DB::instance(DB_NAME)->select_rows($q);
		
			$q = "SELECT SUM(size)
			FROM documents
			WHERE user_id = ".$this->user->user_id;
		
			$doc_size = DB::instance(DB_NAME)->select_field($q);
			
			$this->template->content = View::instance("v_documents_index");
			$this->template->content->docs = $docs;
			$this->template->content->doc_size = $doc_size;
		
			# process the appropriate error to give the user feedback
			if($error == 1) {
				$this->template->content->error = $error;
			} elseif($error == 2) {
				$this->template->content->error = $error;
			}
		
			$this->template->title = $this->user->first_name." ".$this->user->last_name."'s Documents";
	
			echo $this->template;
		
		}
	
		public function p_delete_doc($doc_id) {
		
			# Delete the doc from the docs folder so our server doesn't get too big
			$q = "SELECT doc_code
			FROM documents
			WHERE doc_id = ".$doc_id;
		
			$document = DB::instance(DB_NAME)->select_field($q);
		
			# unlink('/docs/'.$document); Let's figure this out
		
			#Delete the document for them on the site
			DB::instance(DB_NAME)->delete('documents', "WHERE doc_id = ".$doc_id);

			# Bring them to their notes page
			Router::redirect("/documents");
		
		}
	
	} // end class
?>