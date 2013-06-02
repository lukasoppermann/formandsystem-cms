<?php if (! defined('BASEPATH')) exit('No direct script access');
// --------------------------------------------------------------------
/**
 * _item_edit
 *
 * @description	editable menu
 */
function item_edit(&$item, $params = null)
{
	// define variables
	$move_item 		=& $params['move_item'];
	$add_item		=& $params['add_item'];
	$delete_item	=& $params['delete_item'];
	$edit_item		=& $params['edit_item'];

	$class = !empty($params['tmp_item_class']) ? " class='".trim($params['tmp_item_class'])."'" : "";
	// -----------------
	// move
	$move = '<span class="icon move float-left" title="'.$move_item.'"></span>'."\n\t";
	// -----------------
	// edit
	$edit = '<span class="icon edit float-right" title="'.$edit_item.'"></span>'."\n\t";
	// -----------------
	// delete
	$delete = '<span class="icon delete float-right" title="'.$delete_item.'"></span>'."\n\t";
	// -----------------
	//
	return 	"<".$params['item'].$class.">
				<div class='item-wrap'>
					<div id=\"item_".$item['id'].'" data-item="'.$item['id'].'" class="item rounded">'."\n\t".
						$move.
						'<span class="label">'.$item['label'].'</span>'."\n\t".
						$delete.$edit.
					"\n\t"."</div>
					<span class='add right'>+ Neuer Menüpunkt</span>
				</div>\n";
}
// --------------------------------------------------------------------
/**
 * _item_select
 *
 * @description	selectable menu item for entries
 */
function item_select(&$item, $params = null)
{
	$class = !empty($params['tmp_item_class']) ? " class='".trim($params['tmp_item_class'])."'" : "";
	// -----------------
	//
	return 	"<".$params['item'].$class.">
				<div class='item-wrap'>
					<div id=\"item_".$item['id'].'" data-item="'.$item['id'].'" class="item rounded'.(!empty($params['current_item']) && $params['current_item'] == $item['id'] ? " active" : "").'">'."\n\t".
						'<span class="label">'.$item['label'].'</span>'."\n\t".
					"</div>
				</div>\n"; 
}
/* End of file MY_navigation_helper.php */
/* Location: ./system/helpers/MY_navigation_helper.php */