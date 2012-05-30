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
		//
		$this->data['content'] = 'DB Cache: Caching frequently used, but not often changed db queries (need to clear cache on changes)<br /><br />';
		$this->data['content'] .= 'Dynamic routes. Write fs_dynamic_routes.php from cms for page';
		// $data['username'] = ucfirst(user('firstname')).' '.ucfirst(user('lastname'));
		// $data['login_log'] = $this->session->userdata('time_log');
		// $this->data['content'] = '<div id="user" class="widget">'.$this->load->view('widgets/user', $data, TRUE).'</div>';
		// load view
		view('default', $this->data); // $this->data		
	}
	
}