<?php if (! defined('BASEPATH')) exit('No direct script access');

class Dashboard extends MY_Controller {

	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
		
		// css_add('screen','dashboard');
	}
	
	function index()
	{	
		fs_log('In authentication change add_error to add_message');
		//
		// $data['username'] = ucfirst(user('firstname')).' '.ucfirst(user('lastname'));
		// $data['login_log'] = $this->session->userdata('time_log');
		// $this->data['content'] = '<div id="user" class="widget">'.$this->load->view('widgets/user', $data, TRUE).'</div>';
		// load view
		view('default', ''); // $this->data		
	}
	
}