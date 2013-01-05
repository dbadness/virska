<?php

class index_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 
	
	/*-------------------------------------------------------------------------------------------------
	Access via http://yourapp.com/index/index/
	-------------------------------------------------------------------------------------------------*/
	public function index() {
		
		# Any method that loads a view will commonly start with this
		# First, set the content of the template with a view file
		$this->template->content = View::instance('v_index_index');
			
		# Now set the <title> tag
		$this->template->title = "Virska";
	
		# If this view needs any JS or CSS files, add their paths to this array so they will get loaded in the head
			$client_files = Array(
						"/css/index.css"
	                    );
	 		$this->template->client_files = Utils::load_client_files($client_files);
	      		
		# Render the view
		echo $this->template;
	}
		
	public function thank_you() {
		
		$this->template->content = View::instance("v_index_thank_you");
		$client_files = Array(
					"/css/validate.css",
					"/js/validate.js"
                    );
 		$this->template->client_files = Utils::load_client_files($client_files);
		$this->template->title = "Thank You for Requesting Access";
		
		echo $this->template;
	}
	
	public function about() {
		
		$this->template->content = View::instance("v_index_about");
		$client_files = Array(
					"/css/index.css",
					"/js/index.js"
                    );
 		$this->template->client_files = Utils::load_client_files($client_files);
		$this->template->title = "About Virska";
		
		echo $this->template;
	}
	
	public function contact() {
		
		$this->template->content = View::instance("v_index_contact");
		$client_files = Array(
					"/css/index.css",
					"/js/index.js"
                    );
 		$this->template->client_files = Utils::load_client_files($client_files);
		$this->template->title = "Contact Virska";
		
		echo $this->template;
	}
	
	public function legal() {
		
		$this->template->content = View::instance("v_index_legal");
		$client_files = Array(
					"/css/index.css",
					"/js/index.js"
                    );
 		$this->template->client_files = Utils::load_client_files($client_files);
		$this->template->title = "Legal for Virska and Edella, Inc";
		
		echo $this->template;
	}
	
} // end class
