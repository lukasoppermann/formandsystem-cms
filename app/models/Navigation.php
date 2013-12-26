<?php

class Navigation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fs_navigation';

	/**
	 * The nav array
	 *
	 * @var array
	 */
	protected $nav = array();
	
	/**
	 * Get full navigation
	 *
	 * @return mixed
	 */
	public function content()
	{
		return $this->hasMany('Content', 'menu_id', 'id');
	}

	/**
	 * Get nav array
	 *
	 * @return mixed
	 */
	public function getArray( $content = null )
	{
		if(count($this->nav) <= 0)
		{
			$this->buildArray( $content );
		}
		//
		return $this->nav;
	}
	/**
	 * Get full navigation
	 *
	 * @return mixed
	 */
	private function buildArray( $content = null )
	{
		// loop through db data
		foreach($this->get() as $item) 
		{
			$items[$item->parent_id][$item->id] = array(
				 'id' => $item->id,
				 'parent_id' => $item->parent_id,
				 'position' => $item->position
			);
			// add content
			if(isset($content) && isset($content[$item->id]) )
			{
				$items[$item->parent_id][$item->id]['content'] = $content[$item->id];
			}
		}
		// build tree
		foreach($items[0] as $key => $item) 
		{
			// check to not have doubled position values
			$i = 0;
			while( isset($nav[$item['position']+$i]) )
			{
				$i++;
			}
			// add item
			$nav[$item['position']+$i] = $item;
			$nav[$item['position']+$i]['position'] = $item['position']+$i;
			// check for children
			$nav[$item['position']+$i]['children'] = $this->_loop($key, $items);
		}
		// return array
		$this->nav = $nav;
	}
	
	/**
	 * loop
	 *
	 * @return mixed
	 */
	private function _loop($index, &$arr)
	{
		if( isset($arr[$index]) )
		{
			foreach($arr[$index] as $key => $item) 
			{
				// check to not have doubled position values
				$i = 0;
				while( isset($nav[$item['position']+$i]) )
				{
					$i++;
				}
				// add item
				$nav[$item['position']+$i] = $item;
				$nav[$item['position']+$i]['position'] = $item['position']+$i;
				// check for children
				if( isset($arr[$item['id']]) )
				{
					$nav[$item['position']+$i]['children'] = $this->_loop($item['id'], $arr);
				}
			}
			return $nav;
		}
		return $index;
	}

}