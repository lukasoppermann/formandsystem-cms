<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="author" content="Lukas Oppermann – vea.re" />
	<meta name="description" content="{{Config::get('data.description', 'The portfolio of freelance designer Lukas Oppermann, interface design, print design, branding & information graphics')}}" />
	<meta name="robots" content="index,follow" />
	<meta name="language" content="en" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
	{{ Optimization::css('default',false); }}
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<title>{{variable($title)}} | vea.re</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
	<?include("./layout/svg-sprite.svg");?>
	
	@if( isset($error) )
		@include('misc.error', array('error' => $error))
	@endif
	
	@yield('nav','')
	
	<div id="content">
		@yield('content','')
	</div>
	
	<script data-main="{{asset('/js/main')}}" src="{{asset('/js/bower_components/requirejs/require.js')}}"></script>

</body>
</html>