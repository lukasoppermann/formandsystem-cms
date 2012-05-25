<?
	// fs_log('Send emails to retrieve password / user');
?>
<form action="<?=$url?>" method="post" accept-charset="utf-8" name="login" id="login" class="form<?=variable($load_user)?>">
	<?=variable($users);?>
</form>