<?php
use LaravelBook\Ardent\Ardent;

class NavigationModel extends Ardent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fs_navigation';
	/**
	 * Ardent validation rules
	 */
	public static $rules = array(
		// 	  'menu_id' => 'required|integer',
		// 	  'status' => 'required|integer',
		// 	  'link' => 'required|alpha_dash',
		// 	  'language' => 'required|alpha',
		// 'type' => 'required|integer'
	);
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
		return $this->hasMany(\Content::getFacadeRoot(), 'menu_id', 'id');
	}
	
	/**
	 * Get first navigation item
	 *
	 * @return mixed
	 */
	public function getFirst()
	{
		return $this->whereRaw('parent_id = 0 and position = 1')->first();
	}

	/**
	 * Get full navigation
	 *
	 * @return mixed
	 */
	public function getNested()
	{		
		foreach(Navigation::all() as $key => $item)
		{
			$navArray[$item->parent_id][$item->id] = array(
				'id' => $item->id,
				'parent_id' => $item->parent_id,
				'position' => $item->position,
			);
			foreach($item->Content as $c)
			{
				$navArray[$item->parent_id][$item->id]['languages'][] = $c->language;
				$navArray[$item->parent_id][$item->id]['content'][$c->language] = array(
					'id' 					=> $c->id,
					'menu_id' 		=> $item->id,
					'menu_label' 	=> $c->menu_label,
					'link' 				=> $c->link,
					'title' 			=> $c->title,
					'status' 			=> $c->status,
					'language' 		=> $c->language,
					'type'				=> $c->type,
					'data'				=> $c->data,
				);
			}
		}
		// build tree
		$nav = $this->_loop(0,$navArray);
		// return
		return $nav;
	}
	/**
	 * Get full navigation
	 *
	 * @return mixed
	 */
	public function getNavigation()
	{		
		foreach(Navigation::all() as $key => $item)
		{
			$navArray[$item->parent_id][$item->id] = array(
				'id' => $item->id,
				'parent_id' => $item->parent_id,
				'position' => $item->position,
			);
			foreach($item->Content as $c)
			{
				$navArray[$item->parent_id][$item->id]['languages'][] = $c->language;
				$navArray[$item->parent_id][$item->id]['content'][$c->language] = array(
					'id' 					=> $c->id,
					'menu_id' 		=> $item->id,
					'menu_label' 	=> $c->menu_label,
					'link' 				=> $c->link,
					'status' 			=> $c->status,
					'language' 		=> $c->language,
					'type'				=> $c->type,
				);
			}
		}
		// build tree
		$nav = $this->_loop(0,$navArray);
		// return
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