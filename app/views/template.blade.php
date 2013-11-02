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
	<title>{{$title}} | vea.re</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body style="background-color: rgb(105, 195, 160);">
	<div id="header" class="">
		<a href="{{URL::to('/')}}" id="logo_small" class="white-logo no-flicker ajax-link span-2">
			<img class="async-img loaded" data-src-x2="{{URL::to('/')}}/layout/veare-icons@2x.png" data-src-x1="{{URL::to('/')}}/layout/veare-icons.png" src="{{URL::to('/')}}/layout/veare-icons.png"  alt="veare - visionary design, interface design, iOS, webdesign" />
		</a> 
		<ul id="nav" class="montserrat">
			<li class="nav-item anchor active" data-section="about">
				<div class="label">
					<span class="text">About</span>
					<span class="percent"></span>
				</div>
			</li>
			<li class="nav-item anchor" data-section="expertise">
				<div class="label">
					<span class="text">Expertise</span>
					<span class="percent"></span>
				</div>
			</li>
			<li class="nav-item anchor" data-section="portfolio">
				<div class="label">
					<span class="text">Portfolio</span>
					<span class="percent"></span>
				</div>
			</li>
			<li class="nav-item anchor" data-section="philosophy">
				<div class="label">
					<span class="text">Philosophy</span>
					<span class="percent"></span>
				</div>
			</li>
			<li class="nav-item anchor" data-section="contact">
				<div class="label">
					<span class="text">Contact</span>
					<span class="percent"></span>
				<div>
			</li>
		</ul>
	</div>
	
    @yield('content')
	
	{{Optimization::js('default',false);}}
</body>
</html>