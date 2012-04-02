<li data-id="<?=$id?>" data-status="<?=$status?>">
	
	<span class="checkbox"></span>
	<? if(isset($data['modified']))
	{
		echo '<span class="modified">'.$data['modified']['date'].' von '.$data['modified']['author'].'</span>';
	}?>
	<a href="<?=page_url(TRUE).$id?>"><span class="label"><?=$user?></span></a>
	<div class="quick-options">
		<span class="icon edit"></span>
		<span class="icon delete"></span>
	</div>
	<span class="status status-<?=$status?>"></span>
</li>