<?php namespace Lukasoppermann\Optimization;
/*
 * Asset Optimization Library
 *
 * (c) Lukas Oppermann – vea.re
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version 0.9.3
 */

use Config;
use Log;
use App;
use URL;
use Lukasoppermann\Optimization\CssMin;
use Lukasoppermann\Optimization\JSMinPlus;

class Optimization {

    /**
     * drivers
     *
     * @var array
     */
    protected $drivers = array('js','css');
    /**
     * data
     *
     * @var array
     */
    protected $data = array('css' => array());
// --------------------------------------------------------------------
	/**
	 * css shell
	 *
	 * css shell for easy interaction
	 *
	 * @access	public
	 */
	function css()
	{
		$args = func_get_args();
		if( !isset($args) || count($args) == 0 || $args[0] == NULL)
		{
			return $this->get('css', 'default', TRUE, FALSE, NULL);
		}
		else if( is_string($args[0]) && ( isset($this->data['css']['files']) || isset($this->data['css']['lines']) )
			&& ( isset($this->data['css']['files'][$args[0]])
				|| isset($this->data['css']['lines']['after'][$args[0]])
				|| isset($this->data['css']['lines']['before'][$args[0]])
			)
		)
		{
			// set variables
			$compress = isset($args[1]) ? $args[1] : TRUE;
			$link = isset($args[2]) ? $args[2] : FALSE;
			$data = isset($args[3]) ? $args[3] : NULL;

			return $this->get('css', $args[0], $compress, $link, $data);
		}
		else
		{
			$this->add('css', $files = $args[0], $group = (isset($args[1]) ? $args[1] : 'default') );
		}

	}
	// --------------------------------------------------------------------
	/**
	 * js shell
	 *
	 * js shell for easy interaction
	 *
	 * @access	public
	 */
	function js()
	{
		$args = func_get_args();
		if( !isset($args) || count($args) == 0 || $args[0] == NULL)
		{
			return $this->get('js', 'default', TRUE, FALSE, NULL);
		}
		else if( is_string($args[0]) && ( isset($this->data['js']['files']) || isset($this->data['js']['lines']) )
      && ( isset($this->data['js']['files'][$args[0]])
				|| isset($this->data['js']['lines']['after'][$args[0]])
				|| isset($this->data['js']['lines']['before'][$args[0]])
			)
		)
		{
			// set variables
			$compress = isset($args[1]) ? $args[1] : TRUE;
			$link = isset($args[2]) ? $args[2] : FALSE;
			$data = isset($args[3]) ? $args[3] : NULL;

			return $this->get('js', $args[0], $compress, $link, $data);
		}
		else
		{
			 $this->add('js', $files = $args[0], $group = (isset($args[1]) ? $args[1] : 'default') );
		}

	}
	// --------------------------------------------------------------------
	/**
	 * add
	 *
	 * add file, string or array, if array you can use
	 * 'group_name' => 'file_name' notation,
	 * or [] => 'filename' for default group || second (group) param
	 *
	 * @access	public
	 * @param	string / array
	 * @param	string
	 */
	function add($driver, $files = null, $group = 'default')
	{
		$driver = $this->_check_driver($driver);
		// extract files
		$this->extract_files($driver, $files, $group, 'add');
	}
	// --------------------------------------------------------------------
	/**
	 * delete
	 *
	 * delete file, string or array, if array you can use
	 * 'group_name' => 'file_name' notation,
	 * or [] => 'filename' for default group || second (group) param
	 *
	 * @access	public
	 * @param	string / array
	 * @param	string
	 */
	function delete($driver, $files = null, $group = 'default')
	{
		$driver = $this->_check_driver($driver);
		// delete file
		$this->extract_files($driver, $files, $group, 'delete');
	}
	// --------------------------------------------------------------------
	/**
	 * add_lines
	 *
	 * add lines to class
	 *
	 * @access	public
	 * @param	string / array
	 */
	function add_lines($driver, $lines, $group = 'default', $before = FALSE)
	{
		$driver = $this->_check_driver($driver);
		// check if lines are supposed to be set before the files
		$pos = ($before != FALSE ? 'before' : 'after');
		// add lines
		$this->data[$driver]['lines'][$pos][$group] =
		(isset($this->data[$driver]['lines'][$pos][$group]) ? $this->data[$driver]['lines'][$pos][$group].' ' : '').$lines;
	}
	// --------------------------------------------------------------------
	/**
	 * extract files
	 *
	 * extracts files from input
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	string
	 */
	function extract_files($driver, $files, $group, $action)
	{
		if( isset($files) )
		{
			// if has comma, explode into array
			if( is_string($files) && strpos($files, ',') == TRUE )
			{
				// multiple files added
				$files = explode(',', $files);
			}
			// check if string is added
			if( is_string($files) )
			{
				// if single file is added
				if( strpos($files, ',') == FALSE )
				{
					$this->process_file($driver, trim($files), $group, $action);
				}
			}
			// check for array
			elseif( is_array($files) )
			{
				// loop through files
				foreach($files as $file)
				{
					// add file
					$this->process_file($driver, trim($file), $group, $action);
				}
			}
		}
	}
	// --------------------------------------------------------------------
	/**
	 * process file
	 *
	 * adds or deletes file from group
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 */
	function process_file($driver, $file, $group, $action = 'add')
	{
		// if file is external
		if(substr($file, 0, 5) == 'http:' || substr($file, 0, 6) == 'https:' || substr($file, 0, 2) == '//' || substr($file, 0, 4) == 'www.')
		{
			$_file = $file;
		}
		// if element is files (indicated by ".ext" suffix)
		elseif( substr($file, -strrpos($file,'.')) == '.'.Config::get('optimization::'.$driver.'.ext') )
		{
			// if file exists in dir, add
			if( file_exists(Config::get('optimization::'.$driver.'.dir').trim($file, '/')) )
			{
				$_file = Config::get('optimization::'.$driver.'.dir').trim($file, '/');
			}
			// if file exists in other dir on server
			elseif( file_exists('./'.trim($file, '/')) )
			{
				$_file = trim($file, '/');
			}
		}
		// if file exists with this exact name (and added ".ext") in default dir
		elseif(file_exists('./'.Config::get('optimization::'.$driver.'.dir').trim($file, '/').'.'.Config::get('optimization::'.$driver.'.ext')))
		{
			$_file = Config::get('optimization::'.$driver.'.dir').trim($file, '/').'.'.Config::get('optimization::'.$driver.'.ext');
		}
		else
		{
      // find all files in dir/subdirs with name beginning with arg
      $files = glob('./'.Config::get('optimization::'.$driver.'.dir').'{,*/,*/*/,*/*/*/,*/*/*/*/}'.trim($file, '/').'{,-*}'.'.'.Config::get('optimization::'.$driver.'.ext'), GLOB_BRACE);
			// if array is NOT empty, rsort and use the first value (latest Version)
			if(!empty($files))
			{
        rsort($files);
				$_file = substr($files[0], 2);
			}
		}
		// if action = add
		if($action == 'add')
		{
			// check if file is NOT already in array
			if( isset($_file) && ( !isset($this->data[$driver]['files'][$group]) || !in_array($_file, $this->data[$driver]['files'][$group]) ) )
			{
				// add
				$this->data[$driver]['files'][$group][] = $_file;
			}
		}
		elseif($action == 'delete')
		{
			// check if file is in array, DELETE
			if( isset($_file) && ( isset($this->data[$driver]['files'][$group]) && in_array($_file, $this->data[$driver]['files'][$group])) )
			{
				unset($this->data[$driver]['files'][$group][array_search($_file, $this->data[$driver]['files'][$group])]);
			}
		}
	}
	// --------------------------------------------------------------------
	/**
	 * compress
	 *
	 * compress stylesheet files
	 *
	 * @access	public
	 * @param	array
	 * @return 	string
	 */
	function compress($driver, $group = null )
	{
		// check for cache directory, create if it does not exist
		if( !is_dir('./'.Config::get('optimization::'.$driver.'.cache_dir')) )
		{
			mkdir('./'.Config::get('optimization::'.$driver.'.cache_dir'), 0777);
		}
		// set variables
		$gzip = FALSE;
		$ext = '';
		if( substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && !substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip=0') &&
		 	Config::get('optimization::'.$driver.'.gzip') == TRUE )
		{
			$gzip = TRUE;
			$ext = '.gz';
		}
		// check for files and implode
		if( isset($this->data[$driver]['files']) && isset($this->data[$driver]['files'][$group]) )
		{
			$name[] = implode('',$this->data[$driver]['files'][$group]);
		}
		// check for lines
		if( isset($this->data[$driver]['lines']) )
		{
			if( isset($this->data[$driver]['lines']['before']) && isset($this->data[$driver]['lines']['before'][$group]) )
			{
				$name[] = $this->data[$driver]['lines']['before'][$group];
			}
			if( isset($this->data[$driver]['lines']['after']) && isset($this->data[$driver]['lines']['after'][$group]) )
			{
				$name[] = $this->data[$driver]['lines']['after'][$group];
			}
		}
		// add empty files to avoid error
		$files = array();
		// create file name from all files
		$filename = Config::get('optimization::'.$driver.'.cache_dir').md5(implode('',$name)).'.'.Config::get('optimization::'.$driver.'.ext').$ext.'.php';
		// if cache file does not exist or environment is developement
		if( !file_exists('./'.$filename) || in_array(App::environment(), Config::get('optimization::environments')))
		{
			// add lines to before files in file content
			if( isset($this->data[$driver]['lines']['before'][$group]) )
			{
				$output[] = trim($this->data[$driver]['lines']['before'][$group]);
			}
			// check if files exists
			if( isset($this->data[$driver]['files']) && isset($this->data[$driver]['files'][$group]) )
			{
				// merge all files
				foreach( $this->data[$driver]['files'][$group] as $file )
				{
					if( substr($file, 0, 5) == 'http:' || substr($file, 0, 6) == 'https:' || substr($file, 0, 3) == '//:' || substr($file, 0, 4) == 'www.' )
					{
						$files[] = trim($file);
					}
					elseif( file_exists( './'.$file ) )
					{
						// get file content
						$output[] = trim(file_get_contents('./'.$file));
					}
					else
					{
						log_message('debug', 'The file '.$file.' does not exist in the proposed directory.');
					}
				}
			}
			// add lines to file content
			if( isset($this->data[$driver]['lines']['after'][$group]) )
			{
				$output[] = trim($this->data[$driver]['lines']['after'][$group]);
			}
			//
			$output = implode('',$output);
			// check if output has content
			if( $length = strlen($output) > 0 )
			{
				// check if gzip can me used
				if( $gzip === TRUE && Config::get('optimization::'.$driver.'.gzip') == TRUE && ( $length > 1024 || strlen($output) > 1024 ) )
				{
					$header = '<?php
						ob_start("ob_gzhandler");
						header("content-type: '.Config::get('optimization::'.$driver.'.content_type').'; charset: UTF-8");
						header("cache-control: must-revalidate");
						header("expires: ".gmdate(\'D, d M Y H:i:s\', time() + '.Config::get('optimization::'.$driver.'.expire').')." GMT");
					?>';
				}
				// if gzip can't be used
				else
				{
					$header = '<?php header("content-type: '.Config::get('optimization::'.$driver.'.content_type').'; charset: UTF-8");?>';
				}
				// run driver specific output fn
				// MINIFY LOGIC
				if( Config::get('optimization::'.$driver.'.minify') == TRUE )
				{
					if( $driver == 'css' )
					{
						$output = str_replace(array_keys(Config::get('optimization::replace_dirs')), array_values(Config::get('optimization::replace_dirs')),$output);
						$output = CssMin::minify($output);
					}
					elseif( $driver == 'js' )
					{
						$output = str_replace(array_keys(Config::get('optimization::replace_dirs')), array_values(Config::get('optimization::replace_dirs')),$output);
						$output = JSMinPlus::minify($output);
					}
				}
				// add header to output
				$output = trim(preg_replace('#[\r\n|\r|\n|\t|\f|\s]{1,}#',' ',$header).$output);
				// write cache file
				file_put_contents($filename, $output);
				$files[] = $filename;
			}
		}
		// if file exists and not in dev mode, just load the external files
		else
		{
			foreach( $this->data[$driver]['files'][$group] as $file )
			{
				if( substr($file, 0, 5) == 'http:' || substr($file, 0, 6) == 'https:' || substr($file, 0, 3) == '//:' || substr($file, 0, 4) == 'www.' )
				{
					$files[] = trim($file);
				}
			}
			$files[] = $filename;
		}
		// return compressed file
		return $files;
	}
	// --------------------------------------------------------------------
	/**
	 * get
	 *
	 * get files depending on group
	 *
	 * @access	public
	 * @param	string / array
	 * @return 	string
	 */
	function get($driver, $groups = NULL, $compress = TRUE, $link = FALSE, $data = null)
	{

		$driver = $this->_check_driver($driver);
		// if no group is selected
		if( $groups == NULL && ( isset($this->data[$driver]['files'] ) || isset($this->data[$driver]['lines']) )  )
		{
			// loop through all groups
			foreach($this->data[$driver]['files'] as $group => $files)
			{
				$output[] = $this->process($driver, $group, $compress, $link, $data);
			}
		}
		// if group is given
		else
		{
			// check if string with comma
			if( !is_array($groups) && strpos($groups, ',') )
			{
				$groups = explode(',',$groups);
			}
			// just one group
			if( !is_array($groups) )
			{
				// check if group exists
				if( isset($this->data[$driver]['files'][$groups]) || isset($this->data[$driver]['lines']['before'][$groups]) ||
					isset($this->data[$driver]['lines']['after'][$groups]) )
				{
					$output[] = $this->process($driver, $groups, $compress, $link, $data);
				}
			}
			// is array
			else
			{
				// loop through groups
				foreach($groups as $group)
				{
					// check if group exists
					if( isset($this->data[$driver]['files'][$group]) || isset($this->data[$driver]['lines']['before'][$group]) ||
						isset($this->data[$driver]['lines']['after'][$group]) )
					{
						$output[] = $this->process($driver, $group, $compress, $link, $data);
					}
				}
			}
		}
		// return files
		if( isset($output) && is_array($output) )
		{
			return implode('', $output);
		}
	}
	// --------------------------------------------------------------------
	/**
	 * process
	 *
	 * process files
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return 	string
	 */
	function process($driver, $group = NULL, $compress = NULL, $link = FALSE, $data = null)
	{
		// check if any files are present
		if( ( array_key_exists('files', $this->data[$driver]) || array_key_exists('lines', $this->data[$driver]) ) )
		{
			// if compression is activated
			if($compress === TRUE)
			{
				$files = $this->compress($driver, $group);
			}
			// else
			else
			{
				// get files
				if( array_key_exists($group, $this->data[$driver]['files']) )
				{
					$files = $this->data[$driver]['files'][$group];
				}
				// get lines before files
				if(isset( $this->data[$driver]['lines']['before'][$group]) )
				{
					$output[] = "\t".str_ireplace('[file]', $this->data[$driver]['lines']['before'][$group], Config::get('optimization::'.$driver.'.tags.line'))."\n";
				}
				// get lines after files
				if(isset( $this->data[$driver]['lines']['after'][$group]) )
				{
					$lines_after = "\t".str_ireplace('[file]', $this->data[$driver]['lines']['after'][$group], Config::get('optimization::'.$driver.'.tags.line'))."\n";
				}
			}
			// get script-tag
			$tag = (Config::get('optimization::'.$driver.'.tags.'.$group) != NULL) ? Config::get('optimization::'.$driver.'.tags.'.$group) : Config::get('optimization::'.$driver.'.tags.default');
			// check if files are added
			if( isset($files) )
			{
				// loop through files
				foreach($files as $file)
				{
					if( $link != TRUE )
					{
						// if file is external
						if( substr($file, 0, 5) == 'http:' || substr($file, 0, 6) == 'https:' || substr($file, 0, 3) == '//:' || substr($file, 0, 4) == 'www.' )
						{
							$_tag = str_ireplace('[data]', ($data != null ? $data : ''), $tag);
							$output[] = "\t".str_ireplace('[file]', $file, $_tag)."\n";

						}
						// if file is internal: add base url
						else
						{
							$_tag = str_ireplace('[data]', ($data != null ? $data : ''), $tag);
							$output[] = "\t".str_ireplace('[file]', URL::to($file), $_tag)."\n";
						}
					}
					else
					{
						// if file is external
						if( substr($file, 0, 5) == 'http:' || substr($file, 0, 6) == 'https:' || substr($file, 0, 3) == '//:' || substr($file, 0, 4) == 'www.' )
						{
							$output[] = $file;
						}
						else
						{
							$output[] = URL::asset($file);
						}
					}
				}
			}
			// predefine $delimiter
			$delimiter = '';
			if( $link != FALSE && $link !== TRUE )
			{
				$delimiter = $link;
			}
			// check if output exists
			$output = (isset($output) ? implode($delimiter, $output) : '');
			// return files in right syntax
			return ltrim($output,"\t").(isset($lines_after) ? $lines_after : '');
		}
	}
	// --------------------------------------------------------------------
	/**
	 * _check_driver
	 *
	 * checks if driver is valid
	 * else log error
	 *
	 * @access	public
	 * @param	string / array
	 * @param	string
	 */
	function _check_driver($driver)
	{
		if( !in_array( $driver, $this->drivers ) )
		{
			Log::error('Invalid driver: '.$driver);
		}
		return $driver;
	}
}
