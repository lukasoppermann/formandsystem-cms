<div class="wrapper active-user">
	<div class="widget<?=variable($class)?>">
		<div class="widget-content">
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- User Image -->
			<div class="user-image">
				<div class="overlay">
					<div class="fullname"><?=$full_name?></div>
				</div>
				<img class="profile-image" src="<?=media($image, 'images')?>">
			</div>
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- User Name or Email -->
			<input class="user" type="hidden" name="username" value="<?=$user?>" />
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- User Password -->
			<div class="form-element one-row<?=(set_value('password') == null ? ' empty' : '')?>">
				<!-- Forgot Password Bubble -->
				<? if(form_data('fs_password_fails') >= 3 && set_value('username') != null && form_error('password') != null){?>
					<div class="bubble right basic-shadow" id="forgot_password_bubble">
						<div class="bubble-content">
							<?=lang('password_forgot')?> 
							<a data-url="password" data-post="username" class="retrieval-link" id="retrieve_password_link">
								<?=lang('password_forgot_link')?>
							</a>
						</div>
					</div>
				<?} ?>
				<!-- ////////////////////////////////////////////////////////////////////////////////// -->
				<!-- Show Password Icon -->
				<div class="show-password icon fade visible" style="display: none;"></div>
				<!-- Clear Text Input -->
				<input class="password-clear hidden" placeholder="<?=lang('password')?>" value="" />
				<!-- Password Input Field -->
				<input class="password input<?=(form_error('password') != null ? ' error' : ''); ?>" 
				type="password" name="password" placeholder="password" value="<?=set_value('password')?>" />
			</div>
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- Submit Form -->
			<input type="submit" value="" style="visibility: hidden; height: 0px; width: 0px; z-index: -100; position: absolute; left: -200%;"/>
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- Close Form -->
		</div>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- Error Messages -->
		<div class="login-errors <?=(validation_errors() != null ? 'error' : '');?>">
			<?php echo validation_errors('<div class="error">', '</div>'); ?>
		</div>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
	</div>
<!-- closing wrapper -->
</div>	