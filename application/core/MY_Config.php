<?php if (! defined('BASEPATH')) exit('No direct script access');
/**
 * CodeIgniter MY_Config Libraries
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Config
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/core/config
 */
class MY_Config extends CI_Config {

	var $CI, $system;
	
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
		// --------------------------------------------------------------------	
		// MAPPING 
		// TEMPORARY 
		// REMOVE
		
		$this->map('prefix','db_prefix');
		//
	}
	// --------------------------------------------------------------------

	/**
	 * set_config_from_db
	 *
	 * @access	public
	 * @param	array|string	the config item key
	 * @param	string			the config item value
	 * @return	void
	 */
	function set_config_from_db($db = null, $params = array())
	{
		// merge params
		$params = array_merge(array(
					'key' => array('settings', 'system', 'user', 'compression')
				), $params);
		// get CI instance
		$this->CI =& get_instance();
		// check for db name or use default
		$db == null ? $db = $this->item('db_prefix').$this->item('db_data') : '';
		// load database library
		$this->CI->load->database();
		// get data from db
		$this->CI->db->select('id, key, type, data');
		$this->CI->db->from($db);
		foreach($params['key'] as $key)
		{
			$this->CI->db->or_where('key', $key);	
		}
		// get results
		$results = $this->CI->db->get()->result_array();
		// prepare data
		foreach($results as $k => $result)
		{	
			// json_decode data
			$_json = json_decode($result['data'], TRUE);
			foreach($_json as $key => $val)
			{
				$result[$key] = $val;
			}
			unset($result['data']);
			// index by key and type
			if(isset($result['_id']))
			{
				// index by _id id exists
				$config[$result['key']][$result['type']][$result['_id']] = $result;				
			}
			else
			{
				$config[$result['key']][$result['type']][] = $result;
			}
		}
		// -----------------------------------
		// prepare settings
		if( isset($config['settings']) )
		{
			foreach($config['settings'] as $type => $setting)
			{
				if(count($setting) == 1)
				{
					$config['settings'][$type] = $setting[0];
				}
			}
		}
		// -----------------------------------
		// systems
		$this->config['system'] = $config['system'];
		// system - cms
		$this->config['system']['cms'] 	= $config['system']['cms'][key($config['system']['cms'])];
		$this->config['db_prefix'] 		= $config['cms']['db_prefix'];
		$this->config['db_menu']		= $config['cms']['db_menu'];
		$this->config['db_data']		= $config['cms']['db_data'];
		$this->config['db_entries']		= $config['cms']['db_entries'];
		// -----------------------------------
		// users
		$this->config['user'] = $config['user'];
		// -----------------------------------
		// users
		$this->config['compression'] = $config['compression'];
		// -----------------------------------
		// settings
		foreach($config['settings'] as $key => $settings)
		{
			$this->config[$key] = $settings;
		}
	}
// --------------------------------------------------------------------

/**
 * Extend the fn to fetch a config file item
 *
 * @access	public
 * @param	string	the config item name
 * @param	string	the index name
 * @param	bool
 * @return	string
 */
	function item($item, $index = '')
	{
		if ($index == '')
		{
			// check for deep linking
			if( strrpos($item,'/') != FALSE)
			{
				// explode by / to get array levels
				$explode = array_filter(explode('/', $item));
				// count elements
				$c = count($explode);
				$i = 0;
				$_config = $this->config;
				// loop through array
				while($c > $i)
				{
					$_config = $_config[$explode[$i]];
					$i++;
				}
				// return result
				$pref = $_config;
			}
			else
			{
				if ( ! isset($this->config[$item]))
				{
					return FALSE;
				}

				$pref = $this->config[$item];
			}
		}
		else
		{
			if ( ! isset($this->config[$index]))
			{
				return FALSE;
			}

			if ( ! isset($this->config[$index][$item]))
			{
				return FALSE;
			}

			$pref = $this->config[$index][$item];
		}

		return $pref;
	}
// --------------------------------------------------------------------
/**
 * Extend set config item fn, to work with arrays
 *
 * @access	public
 * @param	array|string	the config item key
 * @param	string			the config item value
 * @return	void
 */
	function set_item($item, $value = null)
	{
		// if is array
		if( is_array($item) )
		{
			// loop through array
			foreach($item as $key => $value)
			{
				// check if item exists				
				if(isset($this->config[$key]))
				{
					log_message('debug','Overwriting '.$key.' ('.$this->config[$key].') with '.$value);
				}
				// set item
				$this->config[$key] = $value;
			}
		}
		// if no array
		else
		{
			// check if item exists
			if(isset($this->config[$item]))
			{
				log_message('debug','Overwriting '.$item.' ('.$this->config[$item].') with '.$value);
			}
			// set item
			$this->config[$item] = $value;
		}
	}
// --------------------------------------------------------------------
/**
 * map - map items to other keys
 *
 * @param array | string 
 * @param string 
 * @return string
 */
	function map($key, $item = null)
	{
		if(is_array($key))
		{
			foreach($key as $map => $item)
			{
				// check if item exists
				if(isset($this->config[$map]))
				{
					log_message('debug','Overwriting '.$map.' ('.$this->config[$map].') with '.$this->config[$item]);
				}
				// set config map
				$this->config[$map] = $this->config[$item];
			}
		}
		else
		{
			// check if item exists
			if(isset($this->config[$key]))
			{
				log_message('debug','Overwriting '.$key.' ('.$this->config[$key].') with '.$this->config[$item]);
			}
			// set config map
			$this->config[$key] = $this->config[$item];
		}
	}
// --------------------------------------------------------------------
/**
 * unslash_item - returns config item without slash
 *
 * @param string 
 * @return string
 */
	function unslash_item($item)
	{
		if ( ! isset($this->config[$item]))
		{
			return FALSE;
		}

		return rtrim($this->config[$item], '/');
	}
// --------------------------------------------------------------------
/**
 * system - returns system
 *
 * @param string 
 * @return string
 */	
	function system($item = null, $system = null)
	{
		// return from current system
		if($system == null)
		{
			if( isset($this->config['system']['current'][$item]) )
			{
				return $this->config['system']['current'][$item];
			}
			elseif( $item == 'array' )
			{
				return $this->config['system']['current'];
			}
			else
			{
				return false;
			}
		}
		// return from selected system
		else
		{
			if( isset($this->config['system'][$system][$item]) )
			{
				return $this->config['system'][$system][$item];
			}
			elseif( $item == 'array' )
			{
				return $this->config['system'][$system];
			}
			else
			{
				return false;
			}
		}
	}
// --------------------------------------------------------------------
/**
 * cms - returns cms system
 *
 * @param string 
 * @return string
 */	
	function cms($item = null)
	{
		// return from cms system
		if( isset($this->config['system']['cms'][$item]) )
		{
			return $this->config['system']['cms'][$item];
		}
		elseif( $item == 'array' )
		{
			return $this->config['system']['cms'];
		}
		else
		{
			return false;
		}
	}
// --------------------------------------------------------------------
/**
 * user_group - returns user_group data
 *
 * @param string 
 * @return string
 */	
	function user_group($item = null, $group = null)
	{
		if( isset($this->config['user']['group'][$group][$item]) )
		{
			return $this->config['user']['group'][$group][$item];
		}
		elseif( $item == 'array' && $group != null)
		{
			return $this->config['user']['group'][$group];
		}
		elseif($group == null)
		{
			return $this->config['user']['group'];
		}
		else
		{
			return false;
		}
	}	
// --------------------------------------------------------------------
/**
 * user_right - returns user_right data
 *
 * @param string 
 * @return string
 */	
	function user_right($item = null, $right = null)
	{
		if( isset($this->config['user']['right'][$right][$item]) )
		{
			return $this->config['user']['right'][$right][$item];
		}
		elseif( $item == 'array' && $right != null)
		{
			return $this->config['user']['right'][$right];
		}
		elseif($right == null)
		{
			return $this->config['user']['right'];
		}
		else
		{
			return false;
		}
	}
// --------------------------------------------------------------------
/**
 * compression - returns compression data
 *
 * @param string 
 * @return string
 */	
	function compression($item = null, $type = 'html')
	{
		if( isset($this->config['compression'][$type][$item]) )
		{
			return $this->config['compression'][$type][$item];
		}
		elseif( $item == 'array' )
		{
			return $this->config['compression'][$type];
		}
		else
		{
			return false;
		}
	}
// end of class	
}
/* End of file MY_Config.php */
/* Location: ./application/core/MY_Config.php */