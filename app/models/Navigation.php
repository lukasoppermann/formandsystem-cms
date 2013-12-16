<?php

class Navigation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fs_navigation';

	/**
	 * Get full navigation
	 *
	 * @return mixed
	 */
	public function getNavArray()
	{
		// loop through db data
		foreach($this->get() as $item) 
		{
			$items[$item->parent_id][$item->id] = array(
				 'id' => $item->id,
				 'parent_id' => $item->parent_id,
				 'position' => $item->position
			);
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
		return $nav;
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