<?php

use LaravelBook\Ardent\Ardent;

class ContentModel extends Ardent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fs_content';
	/**
	 * Enable soft deleteing
	 *
	 * @var string
	 */
	protected $softDelete = true;
	/**
	 * Ardent validation rules
	 */
	public static $rules = array(
	  'menu_id' => 'required|integer',
	  'status' => 'required|integer',
	  'link' => 'required|alpha_dash',
	  'language' => 'required|alpha',
		'type' => 'required|integer'
	);
	/**
	 * Define relationships
	 *
	 * @return void
	 */
	function Navigation()
	{
		$this->belongsTo(\Content::getFacadeRoot(), 'menu_id');
	}
	/**
	 * Decode data json
	 *
	 * @return object
	 */
  public function getDataAttribute($value)
	{
		$data = json_decode($value);
		if( is_object($data) )
		{
			return $data;
		}
		return $value;
  }
	/**
	 * GET first menu item with current language
	 *
	 * @return object
	 */
	function getFirst()
	{
		return Navigation::getFirst()->Content->filter(function($content)
		{
			if($content->language == Config::get('content.locale'))
			{
				return $content;
			}
		})->first();
	}
	/**
	 * GET Content by id or link
	 *
	 * @return array
	 */
	function getContent( $id )
	{
		if( !is_numeric( $id ) && $data = $this->whereRaw('link = ? and language = ?', array($id, Config::get('content.locale')) )->first() )
		{
			return $data;
		}
		return Content::find($id);
	}
	
}