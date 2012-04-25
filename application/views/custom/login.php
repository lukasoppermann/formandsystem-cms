<?
	fs_log('Add special error message for blocked user ("Reactivate user -> sends email")');
	fs_log('Send emails to retrieve password / user');	
	fs_log('Send email to login into block user account');
?>
<div class="widget shadow" id="login">
	<form action="<?=$url?>" method="post" accept-charset="utf-8" name="login" class="widget-content">
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- User Image -->
		<div class="user-image">
			<div class="overlay">
				<div class="username">Lukas Oppermann</div>
			</div>
			<img src="<?=media('lukas.jpg', 'images')?>">
		</div>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- User Name or Email -->
		<div class="form-element one-row<?=(set_value('username') == null ? ' empty' : '')?>">
			<!-- Forgot User Bubble -->
			<div class="bubble right basic-shadow <?=(($this->session->userdata('user_blocked') != TRUE && 
			form_error('username') != null) ? '' : ' hidden' )?>" id="forgot_user">
				<div class="bubble-content">
					<p><?=lang('user_forgot')?></p>
					<div class="form-element">
						<input type="text" name="full_name" id="full_name" class="input" value="" placeholder="<?=lang('first_last_name')?>">
						<div id="retrieve_user" class="button"><span class="fade icon submit"></span></div>
					</div>
				</div>
			</div>
			<!-- Blocked User Bubble -->
			<div class="bubble right basic-shadow <?=(($this->session->userdata('user_blocked') == TRUE && 
			form_error('username') != null) ? '' : ' hidden' )?>" id="blocked_user">
				<div class="bubble-content">
					<?=lang('user_blocked')?>
					<a id="retrieve_password"><?=lang('user_blocked_link')?></a>
				</div>
			</div>
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- Help Icon -->
			<div id="show_forgot_user" class="icon fade help"></div>
			<!-- User Input Field -->
			<input class="input<?=(form_error('username') != null ? ' error' : ''); ?>" 
			type="text" id="username" name="username" placeholder="<?=lang('username')?> / <?=lang('email')?>" value="<?=set_value('username')?>" />
		</div>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- User Password -->
		<div class="form-element one-row<?=(set_value('password') == null ? ' empty' : '')?>">
			<!-- Forgot Password Bubble -->
			<? if($this->session->userdata('fs_password_fails') >= 3 && set_value('username') != null && form_error('password') != null){?>
				<div class="bubble right basic-shadow" id="forgot_password">
					<div class="bubble-content">
						<?=lang('password_forgot')?> 
						<a id="retrieve_password"><?=lang('password_forgot_link')?></a>
					</div>
				</div>
			<?} ?>
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- Show Password Icon -->
			<div id="show_password" class="icon fade visible"></div>
			<!-- Clear Text Input -->
			<input id="password_clear" placeholder="<?=lang('password')?>" class="hidden" value="" />
			<!-- Password Input Field -->
			<input class="input<?=(form_error('password') != null ? ' error' : ''); ?>" 
			type="password" id="password" name="password" placeholder="password" value="<?=set_value('password')?>" />
		</div>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- Submit Form -->
		<input type="submit" value="" style="visibility: hidden; height: 0px; width: 0px; z-index: -100; position: absolute; left: -200%;"/>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- Close Form -->
	</form>
	<!-- ////////////////////////////////////////////////////////////////////////////////// -->
	<!-- Error Messages -->
	<div id="login_errors" class="<?=(validation_errors() != null ? 'error' : '');?>">
		<?php echo validation_errors('<div class="error">', '</div>'); ?>
	</div>
	<!-- ////////////////////////////////////////////////////////////////////////////////// -->
</div>