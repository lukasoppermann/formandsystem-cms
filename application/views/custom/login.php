<?

// echo "<pre style='text-align: left; margin: 5px; padding: 8px; border: 1px solid #aaa; background: #fff; float: left; width: 98%; white-space: pre-wrap;'>";
// print_r(form_error('password'));
// echo "</pre>";

?>
<div class="widget shadow" id="login">
	<form action="<?=$url?>" method="post" accept-charset="utf-8" name="login" class="widget-content">
		<div class="user-image">
			<div class="overlay">
				<div class="username">Lukas Oppermann</div>
			</div>
			<img src="<?=media('lukas.jpg', 'images')?>">
		</div>
		<div class="form-element<?=(set_value('password') == null ? ' empty' : '')?>">
			<input class="input<?=(form_error('username') != null ? ' error' : ''); ?>" type="text" id="username" name="username" placeholder="username / email" value="<?=set_value('username')?>" />
		</div>
		<div class="form-element<?=(set_value('password') == null ? ' empty' : '')?>">
			<div id="show_password" class="icon visible"></div>
			<input id="password_clear" placeholder="password" class="hidden" value="" />
			<input class="input<?=(form_error('password') != null ? ' error' : ''); ?>" type="password" id="password" name="password" placeholder="password" value="<?=set_value('password')?>" />
		</div>
		<input type="submit" value="" style="visibility: hidden; height: 0px; width: 0px; z-index: -100; position: absolute; left: -200%;"/>
	</form>
	<div id="login_errors" class="<?=(validation_errors() != null ? 'error' : '');?>">
		<?php echo validation_errors('<div class="error">', '</div>'); ?>
	</div>
</div>