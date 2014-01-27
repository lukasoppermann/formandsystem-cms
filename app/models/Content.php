<?php

class Content extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fs_content';
	/**
	 * Get the unique identifier for the user.
	 *
	 * @var array
	 */
	var $content = array();
	/**
	 * Get content items sorted by menu & language
	 *
	 * @var array
	 */
	var $contentByMenu = array();
	/**
	 * Get content items sorted by menu-link & language
	 *
	 * @var array
	 */
	var $contentByLink = array();
	/**
	 * Get content
	 *
	 * @return mixed
	 */
	function Navigation()
	{
		$this->belongsTo('Content', 'menu_id');
	}
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	function getContent()
	{
		$tmp = Content::get();

		$tmp->each(function($item)
		{
			$item->attributes['content'] = json_decode($item->attributes['content'], true);
		});
		
		$this->content = $tmp->toArray();
	}
	
	function getArray()
	{
		if(count($this->content) <= 0)
		{
			$this->getContent();
		}
		//
		return $this->content;
	}
	
	function getByMenu()
	{
		if(count($this->content) <= 0)
		{
			$this->getContent();
		}
		//
		foreach($this->content as $key => $item)
		{
			$tmp[$item['menu_id']][$item['language']] = $item;
			$tmpLink[$item['link']][$item['language']] = $item;
		}
		$this->contentByMenu = $tmp;
		$this->contentByLink = $tmpLink;
	}
	
	function byMenu()
	{
		if(count($this->contentByMenu) <= 0)
		{
			$this->getByMenu();
		}
		//
		return $this->contentByMenu;
	}
	
	function getByLink( $link = null, $lang = null )
	{
		if(count($this->contentByLink) <= 0)
		{
			$this->getByMenu();
		}
		//
		if( $link !== null && isset($this->contentByLink['/'.trim($link, '/')]) )
		{
			$link = '/'.trim($link, '/');
			if( $lang === null )
			{
				return reset($this->contentByLink[$link]);
			}
			return $this->contentByLink[$link][$lang];
		}
		// no menu item exists
		return false;
	}
	
}