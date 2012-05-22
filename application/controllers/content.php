<?php if (! defined('BASEPATH')) exit('No direct script access');

class Content extends MY_Controller {

	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
		
		// css_add('screen','dashboard');
	}
	
	function index()
	{	
		//
		// $data['username'] = ucfirst(user('firstname')).' '.ucfirst(user('lastname'));
		// $data['login_log'] = $this->session->userdata('time_log');
		// $this->data['content'] = '<div id="user" class="widget">'.$this->load->view('widgets/user', $data, TRUE).'</div>';
		// load view
		view('default', $this->data); // $this->data		
	}
	
	function edit()
	{	
		//
		// $data['username'] = ucfirst(user('firstname')).' '.ucfirst(user('lastname'));
		// $data['login_log'] = $this->session->userdata('time_log');
		// $this->data['content'] = '<div id="user" class="widget">'.$this->load->view('widgets/user', $data, TRUE).'</div>';
		// load view
		view('default', $this->data); // $this->data		
	}
// closing controller	
}
/* End of Controller content.php */