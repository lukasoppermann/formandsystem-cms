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

	var $CI;
	
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
					'key' => array('settings', 'system', 'user')
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
		$this->config = $config;
		//
		// echo "<pre style='text-align: left; margin: 5px; padding: 8px; border: 1px solid #aaa; background: #fff; float: left; width: 98%; white-space: pre-wrap;'>";
		// print_r($config);
		// echo "</pre>";
		// run query
		// $query = $this->CI->db->get();	
		// set $array to collect $row->types
		// $array = array();
		// 	// run through each item
		// 	foreach ($query->result() as $row)
		// 	{
		// 		// if value is a json-string
		// 		if(is_array($values = json_decode($row->value, TRUE)))
		// 		{
		// 			// if json is split into languages
		// 			if(array_key_exists($this->item('lang_id'), $values))
		// 			{
		// 				// set config item wit current language
		// 				$this->set_item($row->type, $values[$this->item('lang_id')]);
		// 			}
		// 			// if json is NOT split into languages
		// 			else
		// 			{
		// 				// if type is NOT in array
		// 				if( !in_array($row->type, $array) )
		// 				{
		// 					// set config item
		// 					$this->set_item($row->type, $values);
		// 					// add type to array
		// 					$array[] = $row->type;
		// 				}
		// 				// if type is in array
		// 				else
		// 				{
		// 					// get data for type
		// 					$value = $this->item($row->type);
		// 					// reset to get first id
		// 					reset($value);
		// 					// if data is array
		// 					if( is_array($value[key($value)]) )
		// 					{
		// 						$value[] = $values;
		// 					}
		// 					// if data is NOT an array
		// 					else
		// 					{
		// 						// nedd this to not have doubling effect
		// 						$val = $value;
		// 						unset($value);
		// 						// add data and new data to array
		// 						$value[] = $val;
		// 						$value[] = $values;
		// 					}
		// 					// set config item
		// 					$this->set_item($row->type, $value);
		// 				}
		// 			}
		// 		}
		// 		// if value is a normal string
		// 		else
		// 		{
		// 			// if type is NOT in array
		// 			if( !in_array($row->type, $array) )
		// 			{
		// 				// set config item
		// 				$this->set_item($row->type, $row->value);
		// 				// add type to array
		// 				$array[] = $row->type;
		// 			}
		// 			// if type is in array
		// 			else
		// 			{
		// 				// get data for type
		// 				$value = $this->item($row->type);
		// 				// if data is array
		// 				if( is_array($value[key($value)]) )
		// 				{
		// 					// add to array
		// 					$value[] = $row->value;
		// 				}
		// 				// if data is NOT an array
		// 				else
		// 				{
		// 					// add this to not have doubling effect
		// 					$val = $value;
		// 					unset($value);
		// 					// add original and new data to array
		// 					$value[] = $val;
		// 					$value[] = $row->value;
		// 				}
		// 				// set config item
		// 				$this->set_item($row->type, $value);					
		// 			}
		// 		}
		// 	}
	}
// --------------------------------------------------------------------

/**
 * Extend the fn to fetch a config file item
 *
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
	
}
/* End of file MY_Config.php */
/* Location: ./application/core/MY_Config.php */