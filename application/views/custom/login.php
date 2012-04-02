<?
echo form_open($url, array('id' => 'login_form', 'class'=>'login-form'));
echo "<h1>LOGIN</h1>";
echo "<div class='username input-container".(form_error('username') ? ' error' : '')."'>";
echo form_input(array(	'name'  		=> 'username',
        						'id'    		=> 'username',
        						'value' 		=> set_value('username',variable($username)),
						'placeholder' 	=> 'Username',
						'class' 		=> 'input-hidden username'));
echo "</div>";

echo "<div class='username input-container".(form_error('password') ? ' error' : '')."'>";								
echo form_password(array('name'  		=> 'password',
        						'id'    		=> 'password',
        						'value' 		=> set_value('password',variable($password)),
						'placeholder' 	=> 'Password',
						'class' 		=> 'input-hidden password'));	
													
echo "</div>";

if( form_error('password') )
{
	echo "<a href='".$url."/forgot-password'>Forgot your password?</a>";
}

echo form_submit('login', 'Login');

echo form_close();
?>