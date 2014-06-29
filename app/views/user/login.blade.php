<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="author" content="Lukas Oppermann – vea.re" />
	<meta name="description" content="{{Config::get('data.description', 'The portfolio of freelance designer Lukas Oppermann, interface design, print design, branding & information graphics')}}" />
	<meta name="robots" content="index,follow" />
	<meta name="language" content="en" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
	<link rel="stylesheet" href="{{asset('/css/login.css')}}" type="text/css" media="screen" charset="utf-8">
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<title>{{variable($title)}} | vea.re</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
	<?include("./layout/svg-sprite.svg");?>
	<div class="login-form">
		<svg viewBox="0 0 512 512" class="icon-formandsystem">
		  <use xlink:href="#icon-formandsystem"></use>
		</svg>
		{{ Form::open(array('url'=>'/login', 'class'=>'form-signin')) }}
	    <h2 class="form-signin-heading">Login to Form&System</h2>
 
	    {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
	    {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
 
	    {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
		{{ Form::close() }}
	</div>
	
	<script data-main="{{asset('/js/login')}}" src="{{asset('/js/bower_components/requirejs/require.js')}}"></script>

</body>
</html>