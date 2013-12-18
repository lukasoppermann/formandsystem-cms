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
<body>
	<nav>
		<ul id="mainnav">
			<li>
				<a class="nav-link" href="#">Dashboard</a>
				<a href="#search" class="search"><span class="icon icon-search"></span></a>
			</li>
			<li>
				<a class="nav-link" href="#">Lukas Oppermann</a>
				<a href="#settings" class="settings"><span class="icon icon-settings"></span></a>
			</li>
		</ul>
		<!-- <ul id="contentnav">
			
			<li class="nav-list-item">
				
				<div class="nav-item">
					
					<a class="nav-link" href="#"><span class="icon icon-page"></span>Home</a>
					
					<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>
					
					<div class="edit-tool page-link-container">
						<span class="icon icon-link"></span>
						<input class="page-link" type="text" value="" placeholder="/link-to-page" />
					</div>
					
					<div class="edit-tool delete"><a href="#delete">delete</a></div>
					
				</div>
				
				<ul>
					<li>
						
						<div class="nav-item">
							<a class="nav-link" href="#"><span class="icon icon-page"></span>Portfolio</a>
							<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>
							<div class="edit-tool page-link-container">
								<span class="icon icon-link"></span>
								<input class="page-link" type="text" value="" placeholder="/link-to-page" />
							</div>
							<div class="edit-tool delete"><a href="#delete">delete</a></div>
						</div>
						
						<ul>
							<li>
								<div class="nav-item active">
									<a class="nav-link" href="#"><span class="icon icon-page"></span>Portfolio</a>
									<a href="#visible" class="edit-tool status"><span class="icon icon-eye"></span></a>
									<div class="edit-tool page-link-container">
										<span class="icon icon-link"></span>
										<input class="page-link" type="text" value="" placeholder="/link-to-page" />
									</div>
									<div class="edit-tool delete"><a href="#delete">delete</a></div>
								</div>
							</li>
						</ul>
						
					</li>
				</ul>
				
			</li>
			
			<li class="contentnav-item active">
				<div class="nav-item">
					
					<a class="nav-link" href="#"><span class="icon icon-stack"></span>Blog</a>
					
					<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>
					
					<div class="edit-tool page-link-container">
						<span class="icon icon-link"></span>
						<input class="page-link" type="text" value="" placeholder="/link-to-page" />
					</div>
					
					<div class="edit-tool delete"><a href="#delete">delete</a></div>
					
				</div>
			</li>
		</ul> -->
		@yield('contentMenu')
	</nav>
	<div id="content">
    	@yield('content')
	</div>
	{{Optimization::js('default',false);}}
</body>
</html>