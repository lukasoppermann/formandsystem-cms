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
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
		// set charset
		Header("Content-type: text/html;charset=UTF-8");
		// set header for browser to not cache stuff
		Header("Last-Modified: " . gmdate( "D, j M Y H:i:s" ) . " GMT"); 
		Header("Expires: " . gmdate( "D, j M Y H:i:s", time() ) . " GMT"); 
		Header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
		Header("Cache-Control: post-check=0, pre-check=0", FALSE); 
		Header("Pragma: no-cache" ); // HTTP/1.0
		// --------------------------------------------------------------------	
		// get systems and system data
		// $array = index_array(get_db_data(config('prefix').config('db_data'), 
		// 							array('where' => array('key' => 'system'), 'select' => 'id, value'), 
		// 							array('add' => array('type' => '1', 'path' => base_url().'$[name]/'.$this->config->unslash_item('lang_abbr').$this->fs_navigation->current('path')))), 'id');
		// 	// get current system
		// 	$system = $this->fs_url->part($array, array('url_position' => 1, 'active_element' => 'name', 'return_element' => 'id', 'config_name' => 'system'));
		// 		// write current system to config
		// 		$this->config->set_item('system',$array[$system]);
		// 		// write $system from system config db entry
		// 		$this->system = $array[$system];
		// 		// get system languages
		// 		$this->system['language'] = sort_array(index_array(get_db_data($this->system['config']['prefix'].$this->system['config']['db_data'], array('where' => array('key' => 'languages'), 'select' => 'value')), 'position'), 'position', TRUE);
		// 		// get system config data
		// 		$system_config = index_array(get_db_data($this->system['config']['prefix'].$this->system['config']['db_data'], 
		// 							array('where' => array('key' => 'settings'), 'select' => 'type, value')), 'type', TRUE);
		// 		$multi = array('menu','type','status','template','channel','category','robots');
		// 		foreach($system_config as $key => $value)
		// 		{
		// 			if(!in_array($key, $multi))
		// 			{
		// 				$this->system[$key] = $value[key($value)];
		// 				unset($this->system[$key]['type']);
		// 			}
		// 			else
		// 			{
		// 				$this->system[$key] = $value;
		// 			}
		// 		}
		// --------------------------------------------------------------------
		// load assets
		css_add('screen',array('base,menu,icons,gui'));
		// js_add_lines('default','CI_ROOT = "'.base_url().'"; CI_BASE = "'.active_url().'"; CURRENT_SYSTEM = "'.$system.'";');
		js_add('default',array('jquery', 'jquery.cookie', 'ui/minified/jquery.ui.core.min', 'ui/minified/jquery.ui.widget.min', 'ui/minified/jquery.ui.mouse.min', 'javascript'));	
		// --------------------------------------------------------------------	
		// check for Logout
		// if($this->fs_navigation->current('path') == '/logout')
		// {
		// 	logout();
		// }
		// --------------------------------------------------------------------
		// Initialize Menus
		// Main
		// $this->data['menu']['main'] = $this->fs_navigation->tree(array('menu' => '10', 'id' => 'main_menu', 'class_lvl_0' => 'main-submenu'));
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
		// $group = current_nav('group', true);
		//
		// echo trim(sha512(salt('lukas', 'exj5IJxo4UJ')));
		// login($group);
	}
	
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */