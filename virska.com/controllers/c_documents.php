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
		
		$this->template->content = View::instance("v_documents_index");
		$this->template->content->docs = $docs;
		$this->template->title = $this->user->first_name." ".$this->user->last_name."'s Documents";
		$client_files = Array(
							"/js/document.js",
							"/css/document.css"
							 );

	    $this->template->client_files = Utils::load_client_files($client_files);
	
		echo $this->template;
		
	}
	
	public function p_upload_doc() {
		
		# Allow the user to create an assignment
		$_POST['user_id'] = $this->user->user_id;
		$_POST['created'] = Time::now(); # this returns the current time
		$_POST['doc'] = $this->user->user_id.$_POST['created'];

		Upload::upload($_FILES, "/docs/", array("pdf", "doc", "xsl", "ppt"), $_POST['doc']);

		#insert data into the database
		DB::instance(DB_NAME)->insert('documents', $_POST);

		Router::redirect("/documents");
		
	}
	
	public function p_delete_doc($doc_id) {
		
		#Delete the note for them
		DB::instance(DB_NAME)->delete('documents', "WHERE doc_id = ".$doc_id);

		# Bring them to their notes page
		Router::redirect("/documents");
		
	}
	
} // end class
?>