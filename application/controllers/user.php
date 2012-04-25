<?php if (! defined('BASEPATH')) exit('No direct script access');

class User extends MY_Controller {
	
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
	}
	
	function index()
	{	
	}
	
	function retrieve($method = null)
	{
		if( $method == 'password' )
		{
			// set log data
			$log = array('message' => lang('recovered_password'), 'username' => $this->input->post('user'));
			// log login attempt
			$this->fs_log->raw_log(array('type' => 3, 'data' => $log));
		}
		elseif( $method == 'user' )
		{
			
		}
		// load email library
		// $this->load->library('email');
		// // set email data
		// $this->email->from('your@example.com', 'Your Name');
		// // $this->email->to('oppermann.lukas@googlemail.com'); 
		// // add subject
		// $this->email->subject('Email Test');
		// // add message
		// $this->email->message('Testing the email class.');	
		// // send email
		// $this->email->send();
		// log retrieval
		
		// return true
		echo 'TRUE';
	}
	
}