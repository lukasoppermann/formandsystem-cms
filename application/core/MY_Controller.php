<?php if (! defined('BASEPATH')) exit('No direct script access');
/**
 * CodeIgniter MY_Controller Libraries
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Controller
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/core/controller
 */
class MY_Controller extends CI_Controller {

	var $data		= null;
	var $system 	= null;
	var $methods 	= null;
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
		//
		// get config from db
		$this->config->set_config_from_db();
		// set charset
		Header("Content-type: text/html;charset=UTF-8");
		// set header for browser to not cache stuff
		Header("Last-Modified: ". gmdate( "D, j M Y H:i:s" ) ." GMT"); 
		Header("Expires: ". gmdate( "D, j M Y H:i:s", time() ). " GMT"); 
		Header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
		Header("Cache-Control: post-check=0, pre-check=0", FALSE); 
		Header("Pragma: no-cache" ); // HTTP/1.0
		// --------------------------------------------------------------------	
		// DEVELOPEMENT		
		fs_benchmark_init();
		// --------------------------------------------------------------------	
		// load assets
		css_add('libs/css/icons.css');
		css_add('base,menu,icons,gui');
		js_add_lines('CI_ROOT = "'.base_url().'"; CI_BASE = "'.active_url().'";', 'default');
		js_add('jquery', 'jquery');
		js_add('jquery.effects.core, fs.local-storage, fs.gui, fs.bubble', 'default');
		// --------------------------------------------------------------------	
		// check for Logout
				
		if( $this->fs_navigation->current('path') == '/logout' )
		{
			logout();
		}
		// check for restore
		if( $this->fs_navigation->current('path') == '/login' && !$this->fs_authentication->login() )
		{
			// get variables from url
			$variables = explode(':',$this->fs_navigation->variables());
			// check if user and key are set
			if( ($user = $variables[0]) != null && ($retrival_key = $variables[1]) != null )
			{
				// load assets
				js_add('fs.login');
				css_add('widgets, login');
				// get user data
				$user = $this->fs_authentication->_get_user($user);
				// assign data for user card
				$data['user'] 				= $user['user'];
				$data['retrieval_key'] 		= $retrival_key;
				$data['retrieval_reset'] 	= (variable($variables[2]) == 'reset') ? 'TRUE' : 'FALSE';
				$data['full_name'] 			= ucfirst($user['firstname']).' '.ucfirst($user['lastname']);
				$data['image'] 				= $user['profile_image']['filename'].'.'.$user['profile_image']['ext'];
				// get user card
				$data['users'] 	= $this->load->view('login/retrieve_user', $data, TRUE);
				// assing data from login
				$data['url'] 	= current_url();
				return view('login/login', $data, TRUE);
			}
		}
		// --------------------------------------------------------------------
		// Initialize Menus
		// Main
		
		foreach($this->config->item('menu') as $menu)
		{
			$this->data['menu'][$menu['name']] = $this->fs_navigation->tree(array_merge($menu, array(
				'menu' 					=> $menu['menu_id'], 
				'id' 					=> $menu['name'].'_menu', 
				'replace_label' 		=> array('[profil]' => ucfirst(user('firstname')).' '.ucfirst(user('lastname')))
			)));	
		}
		// echo "<pre style='text-align: left; margin: 5px; padding: 8px; border: 1px solid #aaa; background: #fff; float: left; width: 98%; white-space: pre-wrap;'>";
		// print_r();
		// echo "</pre>";
		// $this->CI->db->select('id, status, password, salt, email, user, group, data');
		// $this->CI->db->where('user', $username);
		// $this->CI->db->where('status', '1');
		// $this->CI->db->from('users');
		// echo "<pre style='text-align: left; margin: 5px; padding: 8px; border: 1px solid #aaa; background: #fff; float: left; width: 98%; white-space: pre-wrap;'>";
		// print_r($this->data['menu']['main']);
		// echo "</pre>";
		// // // Submenu
		// $this->data['menu']['sub'] = $this->fs_navigation->tree(array('menu' => '10', 'id' => 'sub_menu', 'start_lvl' => '2', 'lvl' => '1', 
		// 							'hide' => array('0', 'shortcut'), 'item_class' => 'submenu-item'));	
		// // Metamenu
		// $this->data['menu']['meta'] = $this->fs_navigation->tree(array('menu' => '11', 'id' => 'meta_menu', 'class_lvl_0' => 'meta-submenu', 
		// 	'replace_label' => array('[profil]' => ucfirst(user('firstname')).' '.ucfirst(user('lastname')))
		// 	));
		// // --------------------------------------------------------------------		
		// // create system menu		
		// $system_switch = $this->fs_navigation->tree(array('id' => 'system_switch', 'item_class' => 'system', 'class' => '', 'hide' => array(), 'active' => array($system), 'menu_data' => array(index_array($array, 'position'))));
		// 		
		$this->data['menu']['system_menu'] = "<ul id='system_menu' class='menu'>
				<li>
					<div class='system-current active'>
						<span class='system-color'></span>
						Form&System
					</div>
					<div class='system-wrapper'>
						<ul class='systems'>
							<li class='system'>
								<span class='system-color' style='border-color:rgb(245,160,10);'></span>veare
							</li>
							<li class='system'>
								<span class='system-color' style='border-color:rgb(225,80,0);'></span>lukasoppermann
							</li>
						</ul>
					</div>
				</li>
				</ul>";
		// 		<li class='current-system' data-system='".$array[$system]['name']."'><a href='".$array[$system]['url']."' target='_blank'>".$array[$system]['label']."</a></li>
		// 	</ul>";
		// --------------------------------------------------------------------		
		// check for sufficient rights
		$group = current_nav('group');
		//
		// echo trim(_sha512(salt('lukas', 'exj5IJxo4UJ')));
		login($group);
	}
	
	// --------------------------------------------------------------------
	/**
	 * direct_call
	 *
	 * @description	directs calls
	 * 
	 */
	function direct_call( $controller, $method = null )
	{
		// load config with calls
		$this->config->load('fs_controller_calls');
		$methods = $this->config->item($controller, 'methods');
		// if method exists
		if( isset($method) && in_array($method, $methods) )
		{
			// call method
			$this->$methods[$method]();
		}
		else
		{
			// else call default
			$this->$methods['default']( $method );
		}
	}
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */