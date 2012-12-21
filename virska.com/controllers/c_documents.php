<?php

class documents_controller extends base_controller {

	public function __construct() {
		parent::__construct();

	}
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
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
		$client_files = Array(
							"/js/document.js",
							"/css/document.css"
							 );

	    $this->template->client_files = Utils::load_client_files($client_files);
	
		echo $this->template;
		
	}
	
	public function p_upload_doc() {
		
		$q = "SELECT count(doc_name)
		FROM documents
		WHERE doc_name = '".$_FILES['doc']['name']."'";
		
		$sum = DB::instance(DB_NAME)->select_field($q);
		
		if($sum == 1) {
			
			# Make sure they're not overwriting an existing document with the same name
			Router::redirect("/documents/upload_error");
			return false;
			
		} else {
		
			# If they're not, allow them to upload their document
			# Set up the $_POST array so the user can upload their document effectively
			$_POST['user_id'] = $this->user->user_id;
			$_POST['created'] = Time::now(); # this returns the current time
			$_POST['size'] = $_FILES['doc']['size'];
			$_POST['doc_name'] = $_FILES['doc']['name'];
			$_POST['doc_code'] = $this->user->user_id."-".$_FILES['doc']['name'];

			Upload::upload($_FILES, "/docs/", array("pdf", "doc", "xsl", "ppt"), substr($_POST['doc_code'], 0, -4));

			#insert data into the database
			DB::instance(DB_NAME)->insert('documents', $_POST);

			Router::redirect("/documents");
		
		}	
	}
	
	public function upload_error() {
		
		$q = "SELECT *
		FROM documents
		WHERE user_id = ".$this->user->user_id;
		
		$docs = DB::instance(DB_NAME)->select_rows($q);
		
		$q = "SELECT SUM(size)
		FROM documents
		WHERE user_id = ".$this->user->user_id;
		
		$doc_size = DB::instance(DB_NAME)->select_field($q);
		
		$upload_error = TRUE;		
		$this->template->content = View::instance("v_documents_index");
		$this->template->content->docs = $docs;
		$this->template->content->doc_size = $doc_size;
		$this->template->content->upload_error = $upload_error;
		$this->template->title = $this->user->first_name." ".$this->user->last_name."'s Documents";
		$client_files = Array(
							"/js/document.js",
							"/css/document.css"
							 );

	    $this->template->client_files = Utils::load_client_files($client_files);
	
		echo $this->template;
		
	}
	
	public function p_delete_doc($doc_id) {
		
		#Delete the note for them
		DB::instance(DB_NAME)->delete('documents', "WHERE doc_id = ".$doc_id);

		# Bring them to their notes page
		Router::redirect("/documents");
		
	}
	
} // end class
?>