<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="author" content="Lukas Oppermann – vea.re" />
	<meta name="description" content="{{Config::get('data.description', 'The portfolio of freelance designer Lukas Oppermann, interface design, print design, branding & information graphics')}}" />
	<meta name="robots" content="index,follow" />
	<meta name="language" content="en" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
	{{Optimization::css('default',false);}}
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<title>{{variable($title)}} | vea.re</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
	<?include("./layout/svg-sprite.svg")?>
	@if( isset($error) )
		@include('misc.error', array('error' => $error))
	@endif
	<nav>
		<ul id="mainnav">
			<li>
				<a class="nav-link" href="#">
					<svg viewBox="0 0 512 512" class="icon-formandsystem">
					  <use xlink:href="#icon-formandsystem"></use>
					</svg>
					Dashboard</a>
				<a href="#search" class="search">
					<svg viewBox="0 0 512 512" class="icon-search">
					  <use xlink:href="#icon-search"></use>
					</svg>
				</a>
			</li>
			<li>
				<a class="nav-link" href="#">Lukas Oppermann</a>
				<a href="#settings" class="settings">
					<svg viewBox="0 0 512 512" class="icon-settings">
					  <use xlink:href="#icon-settings"></use>
					</svg>
				</a>
			</li>
		</ul>
		@yield('contentMenu','')
	</nav>
	<div id="content">
    	@yield('content','')
	</div>
	{{ Optimization::js('default',false) }}
</body>
</html>