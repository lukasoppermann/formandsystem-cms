<?php

use LaravelBook\Ardent\Ardent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ContentModel extends Ardent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $connection = 'user';
	protected $table = 'fs_content';
	/**
	 * Enable soft deleteing
	 *
	 * @var string
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
	/**
	 * Ardent validation rules
	 */
	public static $rules = array(
	  'article_id' => 'required|integer',
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
	function navigation()
	{
		$this->belongsTo(Navigation::getFacadeRoot(), 'article_id', 'article_id');
	}
	/**
	 * Decode data json
	 *
	 * @return object
	 */
  public function getDataAttribute($value)
	{
		$data = json_decode($value);
		if( is_object($data) || is_array($data) )
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
		return "return content & posts, etc for given $id";
		return Content::find($id);
	}
	/**
	 * GET Content & posts, etc. by id or link of main page
	 *
	 * @return array
	 */
	function getPage( $id )
	{
		if( !is_numeric( $id ) && $data = $this->whereRaw('link = ? and language = ?', array($id, Config::get('content.locale')) )->first() )
		{
			$id = $data['id'];
		}
		return Content::find($id);
	}
	/**
	 * GET Posts by id or link of main page
	 *
	 * @return array
	 */
	function getPosts( $id, $postid = null )
	{
		return "return post by id or all posts if no id given";
	}
	
	
}