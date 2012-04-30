<?php
// get random profile
$this->lang->load('profiles');
$profiles = array_values(lang('profiles'));
$profiles = $profiles[rand(0, count($profiles)-1)];
?>
<div class="widget shadow login">
	<div class="add-user">
		<div class="icon add"></div>
	</div>
	<div class="widget-content">
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- User Image -->
		<div class="user-image cms-profile">
			<div class="overlay">
				<div class="username"><?=$profiles['name']?></div>
			</div>
			<img class="profile-image" src="<?=media('profiles/'.$profiles['image'], 'layout')?>">
		</div>
		<!-- ////////////////////////////////////////////////////////////////////////////////// -->
		<!-- User Name or Email -->
		<div class="form-element one-row<?=(set_value('username') == null ? ' empty' : '')?>">
			<!-- Forgot User Bubble -->
			<div class="bubble right basic-shadow <?=((form_data('user_blocked') != 'TRUE' && 
			form_error('username') != null) ? '' : ' hidden' )?>" id="forgot_user_bubble">
				<div class="bubble-content">
					<p><?=lang('user_forgot')?></p>
					<div class="form-element">
						<input type="text" name="full_name" id="full_name" class="input" value="" placeholder="<?=lang('first_last_name')?>">
						<a data-url="userdata" data-post="full_name" class="retrieval-link button" id="retrieve_user_link"><span class="fade icon submit"></span></a>
					</div>
				</div>
			</div>
			<!-- Blocked User Bubble -->
			<div class="bubble right basic-shadow <?=((form_data('user_blocked') == 'TRUE' && 
			form_error('username') != null) ? '' : ' hidden' )?>" id="blocked_user_bubble">
				<div class="bubble-content">
					<?=lang('user_blocked')?>
					<a data-url="blocked_user" data-post="username" class="retrieval-link" id="unblock_user_link"><?=lang('user_blocked_link')?></a>
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
			<? if(form_data('fs_password_fails') >= 3 && set_value('username') != null && form_error('password') != null){?>
				<div class="bubble right basic-shadow" id="forgot_password_bubble">
					<div class="bubble-content">
						<?=lang('password_forgot')?> 
						<a data-url="password" data-post="username" class="retrieval-link" id="retrieve_password_link"><?=lang('password_forgot_link')?></a>
					</div>
				</div>
			<?} ?>
			<!-- ////////////////////////////////////////////////////////////////////////////////// -->
			<!-- Show Password Icon -->
			<div id="show_password" class="icon fade visible" style="display: none;"></div>
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
	</div>
	<!-- ////////////////////////////////////////////////////////////////////////////////// -->
	<!-- Error Messages -->
	<div class="login-errors" class="<?=(validation_errors() != null ? 'error' : '');?>">
		<?php echo validation_errors('<div class="error">', '</div>'); ?>
	</div>
	<!-- ////////////////////////////////////////////////////////////////////////////////// -->
</div>