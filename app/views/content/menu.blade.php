<?
function loop( $nav, $lang){
	echo '<ul>';
	foreach ($nav as $item){
		if ( isset($item['content']) ){
			$content = checkLanguage($item, $lang);

			$mb = $ma = $missing = '';
			$pageIcon = 'icon-page';
			if(isset($content['missing']))
			{
				$missing = 'missing';
				$pageIcon = 'icon-page-add';
			}
			echo '<li class="nav-list-item">
				<div class="nav-item'.('content/'.$lang.'/'.trim($content['link'], '/') == Request::path() ? ' active' : '').'">
					<a class="nav-link '.$missing.'" rel="dns-prefetch" href="'.url('/content/'.$lang.'/'.trim($content['link'], '/')).'">
						<span class="icon '.$pageIcon.'"></span>
							'.$content['menu_label'].$ma.'
					</a>
					<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>

					<div class="edit-tool page-link-container">
						<span class="icon icon-link"></span>
						<input class="page-link" type="text" value="" placeholder="/link-to-page" />
					</div>

					<div class="edit-tool delete"><a href="#delete">delete</a></div>
				</div>';
				if ( isset($item['children']) && is_array($item['children']) ){
					loop($item['children'], $lang);
				}
			echo '</li>';
		}
	}
	echo '</ul>';
}

function checkLanguage($item, $lang)
{
	$languages = array('en','de','fr');
	$key = array_search($lang, $languages);

	if( $key !== false )
	{
		unset($languages[$key]);
	}
	array_unshift($languages, $lang);


	foreach( $languages as $l )
	{
		if( isset($item['content'][$l]) )
		{
			if($l != $lang)
			{
				$item['content'][$l]['missing'] = 'missing';
			}
			return $item['content'][$l];
		}
	}
}

?>
@section('contentMenu')
<div id="contentnav">
	<? loop($nav, 'en'); ?>
<div>
@stop
