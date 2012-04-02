<div id="user_container" class='border-status-<?=$status?>'>
	<?
	// open new form
	echo form_open(current_url(), array('id' => 'user', 'class'=>'user-form'));
	// hidden fields
	echo form_hidden(array(
		'user_id' 	=> variable($id)
	));
	// -----------------------------------------
	// login data
		// username
		echo '<div id="username_box">';
		echo form_input(array(	'name'  		=> 'username',
	         					'id'    		=> 'username',
	         					'value' 		=> set_value('username',variable($user)),
								'placeholder' 	=> 'Username des Nutzers',
								'class' 		=> 'input-hidden title'));
		echo '</div>';
		// email
		echo '<div id="email_box">';
		echo form_input(array(	'name'  		=> 'email',
	         					'id'    		=> 'email',
	         					'value' 		=> set_value('email',variable($email)),
								'placeholder' 	=> 'Email des Nutzers',
								'class' 		=> 'input-hidden title'));
		echo '</div>';
		// password
		echo '<div id="password_box">';
		echo form_password(array('name'  		=> 'new_password',
	         					'id'    		=> 'new_password',
	         					'value' 		=> set_value('new_password'),
								'placeholder' 	=> 'Passwort',
								'class' 		=> 'input-hidden title'));
		echo '</div>';
		// password retype
		echo '<div id="repassword_box">';
		echo form_password(array('name'  		=> 'repassword',
	         					'id'    		=> 'repassword',
	         					'value' 		=> set_value('repassword'),
								'placeholder' 	=> 'Re-type Passwort',
								'class' 		=> 'input-hidden title'));
		echo '</div>';
		// keep login
		echo '<div id="keep_login_box">';
		echo '<label for="keep_login">Keep user logged in</label> ';
		echo form_checkbox(array(	'name'  	=> 'keep_login',
	         						'id'    	=> 'keep_login',
									'value'     => "TRUE",
	         						'checked' 	=> variable($data['keep_login'])));
		echo '</div>';
	// -----------------------------------------
	// cms data
	echo '<div id="group_box">';
	echo form_dropdown('group', $groups, set_value("group", variable($group)));
	echo '</div>';
	// -----------------------------------------
	// user data
	// prepare data
	$name = variable($data['firstname']).' '.variable($data['lastname']);
	$name == ' ' ? $name = '' : '';
	//
	// real name
	echo '<div id="name_box">';
	echo form_input(array(	'name'  		=> 'name',
         					'id'    		=> 'name',
         					'value' 		=> set_value('name',variable($name)),
							'placeholder' 	=> 'Name des Nutzers',
							'class' 		=> 'input-hidden title'));
	echo '</div>';
	// -----------------------------------------	
	// save
	echo '<div id="save_box">';
		echo '<div id="save" class="button">save changes</div>';
	echo '</div>';
	// close form
	echo form_close();
	?>	
</div>