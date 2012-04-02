<li data-id="<?=$id?>" data-language="<?=$data['language']?>" data-status="<?=$data['status']?>" data-type="<?=$type?>"> 
	<!-- <div class="item"> -->
		<span class="checkbox"></span>
		<? if(isset($data['modified']))
		{
			echo '<span class="modified">'.$data['modified']['date'].' von '.$data['modified']['author'].'</span>';
		}?>
		<a href="<?=page_url(TRUE).$id?>"><span class="label"><?=$title?></span></a>
		<div class="quick-options">
			<span class="icon edit"></span>
			<span class="icon delete"></span>
		</div>
		<span class="status status-<?=$data['status']?>"></span>
	<!-- </div> -->
</li>