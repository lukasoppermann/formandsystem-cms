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
			<!-- retrieval -->
			<input class="retrieval-key" type="hidden" name="retrieval_key" value="<?=$retrieval_key?>" />
			<input class="retrieval-reset" type="hidden" name="retrieval_reset" value="<?=$retrieval_reset?>" />
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- User Name or Email -->
			<input class="username" type="hidden" name="username" value="<?=$user?>" />
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- User Password -->
			<div class="form-element one-row<?=(set_value('password') == null ? ' empty' : '')?>">
				<!-- Blocked User Bubble -->
				<div class="bubble right basic-shadow blocked-user-bubble hidden">
					<div class="bubble-content">
						<?=lang('user_blocked')?>
						<a data-url="blocked_user" data-post="username" class="retrieval-link unblock-user-link"><?=lang('user_blocked_link')?></a>
					</div>
				</div>
				<!-- Forgot Password Bubble -->
					<div class="bubble right basic-shadow forgot-password-bubble hidden">
						<div class="bubble-content">
							<?=lang('password_forgot')?> 
							<a data-url="password" data-post="username" class="retrieval-link" id="retrieve_password_link">
								<?=lang('password_forgot_link')?>
							</a>
						</div>
					</div>
				<!-- ////////////////////////////////////////////////////////////////////////////////// -->
				<!-- Show Password Icon -->
				<div class="show-password icon fade visible" style="display: none;"></div>
				<!-- Clear Text Input -->
				<input class="password-clear hidden" value="" />
				<!-- Password Input Field -->
				<input class="password input<?=(form_error('password') != null ? ' error' : ''); ?>" 
				type="password" name="password" placeholder="<?=lang('password')?>" value="" />
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