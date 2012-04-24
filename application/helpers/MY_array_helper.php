<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/helpers/array
 */

// ------------------------------------------------------------------------
/**
 * sort_array - sorts array by content of key
 *
 * @param array to be sorted
 * @param string key to be sorted by
 * @param array params
 * @return array (sorted)
 */
function sort_array($array, $subkey, $params = array())
{
	// merge params array
	$params = array_merge(array(
		'use_key' 	=> FALSE,
		'sort' 		=> 'asc', // vs desc
		'remove' 	=> false // remove empty from array
	), $params);
	// build sorter array
	foreach($array as $key => $value)
	{
		if( isset($value[$subkey]) )
		{
			$sorter[$key] = strtolower($value[$subkey]);
		}
		else
		{
			$rest[$key] = strtolower(variable($value[$subkey]));
		}
	}
	// sort array depending on param
	if($params['sort'] == 'asc')
	{
		asort($sorter);		
	}
	else
	{
		arsort($sorter);	
	}
	// create new sorted array
	foreach($sorter as $k => $v) 
	{
		$sorted_array[$k] = $array[$k];
	}
	// if remove = false, add rest
	if($params['remove'] == false && isset($rest))
	{
		foreach($rest as $k => $v) 
		{
			$sorted_array[$k] = $array[$k];
		}
	}
	// if use_keys is deactive, remove keys
	if($params['use_key'] == FALSE)
	{
		$sorted_array = array_values($sorted_array);
	}
	// return array
	return $sorted_array;
}

// ------------------------------------------------------------------------
/**
 * array_depth - returns the depth of the array
 *
 * @param array
 * @return int
 */
function array_depth($array) 
{
	// init maximal depth (deepest child)
	$max_depth = 1;
	// print array as string
	$array_str = print_r($array, true);
	// explode string by line breaks
	$lines = explode("\n", $array_str);
	// loop through lines and check for depth
	foreach ($lines as $line) 
	{
		// get depth for current loop
		$depth = ( strlen($line) - strlen( ltrim($line) ) ) / 4;
		// if depth is deeper
		if ($depth > $max_depth) 
		{
			// set max depth to depth
			$max_depth = $depth;
 		}
	}
	// return depth
    return ceil( ($max_depth - 1) / 2) + 1;
}
// ------------------------------------------------------------------------
/**
 * add_array - add data to array
 *
 * @param array
 * @param array
 * @return array
 */
function add_array($array, $args)
{
	// loop through args to add
	foreach($args as $key => $value)
	{
		// get array depth by exploding by /
		$key = explode('/', $key);
		// add to array using fn _add_array
		$array = _add_array($array, $key, $value);
	}
	// return new array
	return $array;
}
// ------------------------------------------------------------------------
/**
 * _add_array - add data to array
 *
 * @param array
 * @param array
 * @param string
 * @return array
 */
function _add_array($array = array(), $keys, $value)
{
	// while fn needs to go deeper into array
	if(count($keys) > 1)
	{
		// get current key
		reset($keys);
		$key = $keys[key($keys)];
		// remove current key from keys
		unset($keys[key($keys)]);
		// if key exists merge
		if( isset($array[$key]) )
		{
			$array[$key] = _add_array($array[$key], $keys, $value);
		}
		// if key does not exists add
		else
		{
			$array[$key] = _add_array($array, $keys, $value);	
		}
	}
	// if right depth in array is reached
	else
	{
		// get current key
		$key = $keys[key($keys)];
		// if key exists merge
		if( isset($array[$key]) && is_array($array[$key]) )
		{
			$array[$key] = array_merge($array[$key], (array) $value);		
		}
		// if key does not exists add
		else
		{
			$array[$key] = $value;			
		}
	}
	// return new array
	return $array;
}
// ------------------------------------------------------------------------
/**
 * add_json - add data to json array
 *
 * @param string
 * @param array
 * @return string
 */
function add_json($json, $array)
{
	// convert to array
	$json = json_decode($json, TRUE);
	// add to array
	$json = add_array($json, $array);
	// convert to json string	
	return json_encode($json);
}
// ------------------------------------------------------------------------
/**
 * delete_array - delete data from array
 *
 * @param array
 * @return array
 */
function delete_array($array)
{
	// get arguments
	$args = func_get_args();
	// unset first arg, b/c it is the array
	unset($args[0]);
	// if args = array in array, turn into just array
	if(isset($args[1]) && is_array($args[1]))
	{
		$args = $args[1];
	}
	// remove specified fields from array
	$array = _delete_array($array, $args);
	// remove empty elements from array
	$array = empty_array($array);
	// return array
	return $array;
}
// ------------------------------------------------------------------------
/**
 * _delete_array - delete data from array
 *
 * @param array
 * @param array
 * @param string
 * @return array
 */
function _delete_array($array, $keys, $key = '')
{
	// loop through array
	foreach($array as $k => $value)
	{
		// get current key
		$key = trim($key.'/'.$k,'/');
		// check if key is supposed to stay & $value is not an array
		if( !in_array($key, $keys) && !is_array($value) )
		{
			$new_array[$k] = $value;
		}
		// if value is array go deeper
		elseif(!in_array($key, $keys))
		{
			$new_array[$k] = _delete_array($value, $keys, $key);
		}
		$key = str_replace($k, '', $key);
		$key = trim($key, '/');
	}
	// return new array
	return variable($new_array);
}
// ------------------------------------------------------------------------
/**
 * delete_json - delete data from json array
 *
 * @param string
 * @return string
 */
function delete_json($json)
{
	// convert to array
	$json = json_decode($json, TRUE);	
	// get args
	$args = func_get_args();
	unset($args[0]);
	// delete from array
	$json = delete_array($json, $args);
	// convert to json
	return json_encode($json);
}
// ------------------------------------------------------------------------
/**
 * get_json - get data from json array
 *
 * @param string
 * @param string
 * @return string
 */
function get_json($json, $key)
{
	// decode json
	$array = json_decode($json, TRUE);
	// get array keys for all levels
	$keys = explode('/', $key);
	// count keys
	$count_keys = count($keys);
	// loop through keys
	for( $i = 0; $i < $count_keys; ++$i )
	{
		// while key exists go deeper
		if(array_key_exists($keys[$i], $array))
		{
			$array = $array[$keys[$i]];
		}
		// if key does not exists, return false
		else
		{
			return False;
		}
	}
	// return array
	return $array;
}
// ------------------------------------------------------------------------
/**
 * empty_array - delete empty elements from array
 *
 * @param array
 * @return array
 */

function empty_array($array)
{
	// loop through array
	foreach($array as $key => $element)
	{
		// if element is empty delete it
		if( empty($element) )
		{
			unset($array[$key]);
		}
		// if element is array
		elseif( is_array($array[$key]) )
		{
			// loop through children
			$array[$key] = empty_array($array[$key]);
		}
	}
	// return clean array
	return $array;
}
// ------------------------------------------------------------------------

/**
 * Index Array - Changes the array key to be sorted by different array value
 *
 * @access	public
 * @param	array
 * @param	string
 * @return	array
 */	
function index_array($array, $index, $multi = FALSE)
{
	// if multikey = TRUE
	if($multi == TRUE)
	{
		// loop through array
		foreach($array as $key => $value)
		{
			$new_array[$value[$index]][$key] = $value;		
		}
	}
	// if unique keys expected
	else
	{
		// loop through array
		foreach($array as $key => $value)
		{
			$new_array[$value[$index]] = $value;		
		}
	}
	// check if array exists
	if( isset($new_array) && is_array($new_array) )
	{
		return $new_array;
	}
	else
	{
		// if array does not exists return empty array
		return array(null);
	}
}
// ------------------------------------------------------------------------

/**
 * IS Index Array - Changes the array key to be sorted by different array value only returns if index exists
 *
 * @access	public
 * @param	array
 * @param	string
 * @return	array
 */	
function is_index_array($array, $index)
{
	foreach($array as $key => $value)
	{
		if(isset($value[$index]))
		{
			$new_array[$value[$index]] = $value;
		}
	}
	return $new_array;
}
// ------------------------------------------------------------------------

/**
 * array_key_exists_nc - array_key_exists but case insensitive
 *
 * @access	public
 * @param	array
 * @param	string
 * @return	array
 */
function array_key_exists_nc($key, $search)
{
	// check if array_key_exists works (faster)
    if(array_key_exists($key, $search)) 
	{
        return $key;
    }
	// if not check for wrong parameters
    if( !(is_string($key) && is_array($search) && count($search)) ) 
	{
        return false;
    }
	// if params are right, convert key to lower case
    $key = strtolower($key);
	// loop through array and convert keys to lower case
    foreach($search as $k => $v) 
	{
        if(strtolower($k) == $key) 
		{
            return $k;
        }
    }
    return false;
}
/* End of file MY_array_helper.php */
/* Location: ./application/helpers/MY_array_helper.php */