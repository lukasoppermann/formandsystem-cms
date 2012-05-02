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

	var $data	= null;
	var $system = null;
	var $test = null;
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
		$this->output->enable_profiler(TRUE);
		// --------------------------------------------------------------------	
		// load assets
		css_add('libs/css/icons.css');
		css_add('base,icons,gui');
		js_add_lines('CI_ROOT = "'.base_url().'"; CI_BASE = "'.active_url().'";', 'default');
		js_add('jquery, jquery.effects.core.min, fs.gui', 'default');
		$db = 'cms_entries';
		$data = array('menu_id' => 5, 'title' => 'New Title', 'data' => array('user' => 'test', 'peter' => 'schmidt'));
		$data = array($data, array('menu_id' => '16', 'title' => '3', 'data' => 'test'));
		// js_add('default', array('jquery', 'jquery.cookie', 'ui/minified/jquery.ui.core.min', 'ui/minified/jquery.ui.widget.min', 'ui/minified/jquery.ui.mouse.min', 'javascript'));	
		// --------------------------------------------------------------------	
		// check for Logout
		if($this->fs_navigation->current('path') == '/logout')
		{
			logout();
		}	
		// --------------------------------------------------------------------
		// Initialize Menus
		// Main
		foreach($this->config->item('menu') as $menu)
		{
			$this->data['menu'][$menu['name']] = $this->fs_navigation->tree(array(
				'menu' => $menu['menu_id'], 
				'id' => $menu['name'].'_menu', 
				'class_lvl_0' => variable($menu['class']), 
				'start_lvl' => variable($menu['start_lvl']), 
				'lvl' => variable($menu['lvl']), 
				'hide' => variable($menu['hide']))
			);	
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
		// $this->data['menu']['system_menu'] = "<ul id='system_menu'>
		// 		<li class='arrow-down-li'>
		// 			<span class='arrow-down-span'></span>
		// 			".$system_switch."
		// 		</li>
		// 		<li class='current-system' data-system='".$array[$system]['name']."'><a href='".$array[$system]['url']."' target='_blank'>".$array[$system]['label']."</a></li>
		// 	</ul>";
		// --------------------------------------------------------------------		
		// check for sufficient rights
		$group = current_nav('group', true);
		//
		// echo trim(_sha512(salt('lukas', 'exj5IJxo4UJ')));
		login($group);
		$data['content'] = 'test';
	}
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */