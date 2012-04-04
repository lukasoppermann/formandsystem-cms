<?php if (! defined('BASEPATH')) exit('No direct script access');
/**
 * CodeIgniter myconfigs
 *
 * @package		CodeIgniter
 * @subpackage	Hooks
 * @category	Config
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/hooks/myconfigs
 */
class myconfigs{
	
	function set_config_from_db()
	{
		$CI =& get_instance();
		$CI->config->set_config_from_db($CI);
	}
}