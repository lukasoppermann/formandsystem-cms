<?php if (! defined('BASEPATH')) exit('No direct script access');

class Content extends MY_Controller {
	
	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
	}
	// --------------------------------------------------------------------
	/**
	 * index
	 *
	 * @description	directs calls
	 * 
	 */
	function index( $method = null )
	{
		$this->direct_call(strtolower(get_class($this)), $method);
	}
	// --------------------------------------------------------------------
	/**
	 * view
	 *
	 * @description	view contents
	 * 
	 */
	function view( )
	{
		// load assets
		css_add('content');
		// get content from db
		$entries = db_select(config('system/current/prefix').config('db_entries'), false, array('json' => 'data'));
		// prepare entries
		foreach( $entries as $key => $entry )
		{
			$display[] = $this->load->view('content/item', $entry, TRUE);
		}
		$this->data['content'] = implode('', $display);
		// view
		view('content/view', $this->data);
	}
	// --------------------------------------------------------------------
	/**
	 * edit
	 *
	 * @description	edit content
	 * 
	 */
	function edit( $id = null )
	{	
		if( $id == null )
		{
			$this->view();
		}
		else
		{
			if( $this->input->post('title') != null )
			{
				$this->save();
			}
			// load assets
			css_add('content');
			// get content from db
			$entries = db_select(config('system/current/prefix').config('db_entries'), array('id' => $id), array('json' => 'data', 'single' => TRUE));
			// 
			$this->data['content'] = $this->load->view('content/edit', $entries, TRUE);
			// view
			view('content/view', $this->data);
		}	
	}
	// --------------------------------------------------------------------
	/**
	 * save
	 *
	 * @description	save content
	 * 
	 */
	function save( )
	{
		$fields = array('title','data/meta_title' => 'meta_title','data/excerpt'=>'excerpt','text','permalink','tags','status');
		//
		foreach($fields as $key => $field)
		{
			if( is_int($key) && strlen($key) <= 2 )
			{
				$data[$field] = $this->input->post($field);
			}
			else
			{
				$data = add_array($data, array($key => $this->input->post($field)));
			}
		}
		$data['data'] = json_encode($data['data']);
		// update db
		db_update(config('system/current/prefix').config('db_entries'), array('id'=>$this->input->post('id')), $data, FALSE, array('data'));
	}
// closing controller	
}
/* End of Controller content.php */