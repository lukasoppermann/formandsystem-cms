<?
// Config::set('content.locale', 'de');
function loop( $nav, $lang){
	echo '<ul>';
	foreach ($nav as $item)
	{
		// $content = checkLanguage($item, Config::get('content.locale'));
		if( isset($item['content']) )
		{
			if( array_key_exists(Config::get('content.locale'), $item['content']) )
			{
				$itemContent = $item['content'][Config::get('content.locale')];
			}
			else
			{
				$i = 0;
				while( !isset($itemContent) && $i < count(Config::get('content.languages')) )
				{
					if( array_key_exists(array_values(Config::get('content.languages'))[$i], $item['content']) )
					{
						$itemContent = $item['content'][array_values(Config::get('content.languages'))[$i]];
						$itemContent['missing'] = 'missing';
						$itemContent['language'] = array_values(Config::get('content.languages'))[$i];
					}
					$i++;
				}
			}

			$pageIcon = 'page';
			$missing = '';
			$link = url('/content/'.trim($itemContent['link'], '/'));
			if(isset($itemContent['missing']))
			{
				$missing = 'missing';
				$pageIcon = 'page-add';
				$itemContent['menu_label'] = $itemContent['language'].': '.$itemContent['menu_label'];
				$link = url('/content/create/');
			}

			echo '<li class="nav-list-item">
				<div class="nav-item'.('content/'.trim($itemContent['link'], '/') == Request::path() ? ' active' : '').'">
					<a class="nav-link '.$missing.'" rel="dns-prefetch" data-id="'.$itemContent['id'].'" href="'.$link.'">
						<svg viewBox="0 0 512 512" class="icon-'.$pageIcon.'">
					  	<use xlink:href="#icon-'.$pageIcon.'"></use>
						</svg>
							'.$itemContent['menu_label'].'
					</a>
					<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>

					<div class="edit-tool page-link-container">
						<label>
							<svg viewBox="0 0 512 512" class="icon-link">
					  		<use xlink:href="#icon-link"></use>
							</svg>
							<input class="page-link" type="text" value="" placeholder="/link-to-page" />
						</label>
					</div>

					<a class="edit-tool delete" href="'.url('/content/destroy/'.$itemContent['id']).'">delete</a>
				</div>';
				if ( isset($item['children']) && is_array($item['children']) ){
					loop($item['children'], $lang);
				}
			echo '</li>';
			$itemContent = null;
		}
	}
	echo '</ul>';
}

?>
@section('contentMenu')
<div id="scroll_indicator"></div>
<div id="contentnav">
	<? loop($nav, 'en'); ?>
<div>
@stop
