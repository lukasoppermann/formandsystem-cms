<?php
// get random profile
$this->lang->load('profiles');
$profiles = array_values(lang('profiles'));
$profiles = $profiles[rand(0, count($profiles)-1)];
?>
<div class="perspective wrapper" style="display:none;">
	<div class="widget login">
		<div class="card">
			<div class="add-user side front">
				<div class="add-icon"></div>
			</div>
			<div class="widget-content side back">
				<!-- ////////////////////////////////////////////////////////////////////////////////// -->
				<!-- User Image -->
				<div class="user-image cms-profile">
					<div class="overlay">
						<div class="fullname"><?=$profiles['name']?></div>
					</div>
					<img class="profile-image" src="<?=media('profiles/'.$profiles['image'], 'layout')?>">
				</div>
				<!-- ////////////////////////////////////////////////////////////////////////////////// -->
				<!-- User Name or Email -->
				<div class="form-element one-row<?=(set_value('username') == null ? ' empty' : '')?>">
					<!-- Forgot User Bubble -->
					<div class="bubble basic-shadow hidden" id="forgot_user_bubble">
						<div class="bubble-content">
							<p><?=lang('user_forgot')?></p>
							<div class="form-element">
								<input type="text" name="full_name" id="full_name" class="input" value="" placeholder="<?=lang('first_last_name')?>">
								<a data-url="userdata" data-post="full_name" class="retrieval-link button" id="retrieve_user_link">
								<span class="fade icon submit"></span></a>
							</div>
						</div>
					</div>
					<!-- Blocked User Bubble -->
					<div class="bubble basic-shadow blocked-user-bubble" style="display: none;">
						<div class="bubble-content">
							<?=lang('user_blocked')?>
							<a data-url="blocked_user" data-post="username" class="retrieval-link unblock-user-link"><?=lang('user_blocked_link')?></a>
						</div>
					</div>
					<!-- ////////////////////////////////////////////////////////////////////////////////// -->
					<!-- Help Icon -->
					<div id="show_forgot_user" class="icon fade help"></div>
					<!-- User Input Field -->
					<input class="username input<?=(form_error('username') != null ? ' error' : ''); ?>" 
					type="text" name="fs_username" placeholder="<?=lang('username')?> / <?=lang('email')?>" value="<?=set_value('username')?>" />
				</div>
				<!-- ////////////////////////////////////////////////////////////////////////////////// -->
				<!-- User Password -->
				<div class="form-element one-row<?=(set_value('password') == null ? ' empty' : '')?>">
					<!-- Forgot Password Bubble -->
						<div class="bubble basic-shadow forgot-password-bubble" style="display:none;">
							<div class="bubble-content">
								<?=lang('password_forgot')?> 
								<a data-url="password" data-post="username" class="retrieval-link" id="retrieve_password_link"><?=lang('password_forgot_link')?></a>
							</div>
						</div>
					<!-- ////////////////////////////////////////////////////////////////////////////////// -->
					<!-- Show Password Icon -->
					<div class="show-password icon fade visible" style="display: none;"></div>
					<!-- Clear Text Input -->
					<input class="password-clear hidden" value="" />
					<!-- Password Input Field -->
					<input class="password input<?=(form_error('password') != null ? ' error' : ''); ?>" 
					type="password" name="fs_password" placeholder="<?=lang('password')?>" value="" />
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
	</div>
	<!-- closing wrapper -->
</div>	