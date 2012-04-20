<?php echo validation_errors('<div class="error">', '</div>'); ?>

<div class="widget shadow" id="login">
	<form name="login" class="widget-content">
		<div class="user-image">
			<div class="overlay">
				<div class="username">Lukas Oppermann</div>
			</div>
			<img src="<?=media('lukas.jpg', 'images')?>">
		</div>
		<?php echo validation_errors('<div class="error">', '</div>'); ?>
		<div class="form-element<?=(form_error('username') != null ? ' error' : ''); ?>">
			<input class="input" type="text" id="username" name="username" placeholder="username / email" value="" />
		</div>
		<div class="form-element<?=(form_error('password') != null ? ' error' : ''); ?>">
			<input class="input" type="text" id="password" name="password" placeholder="password" value="" />
		</div>
	</form>
</div>