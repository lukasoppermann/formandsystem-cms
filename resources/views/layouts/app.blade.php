<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>{{$title or 'Focus on the important parts, leave the rest to us'}} – Form&System</title>
        <meta http-equiv="content-language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
        <meta name="theme-color" content="rgb(255,212,39)">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="site_url" content="{{ url('/') }}">
        <link href="{{ asset(env('FILE_PREFIX').elixir('css/app.css'), Request::secure()) }}" rel="stylesheet" type="text/css">
        <link href='//fonts.googleapis.com/css?family=Lato:300,400,700&subset=latin,latin' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="{{ asset(env('FILE_PREFIX').elixir('js/webcomponents-lite.min.js'), Request::secure()) }}"></script>
        <link rel="import" href="{{ asset(env('FILE_PREFIX').elixir('webcomponents/webcomponents.html'), Request::secure()) }}">
        @if (env('APP_ENV') !== 'local')
            <script {{csp_none()}}>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
              ga('create', 'UA-7074034-25', 'auto');
              ga('require', 'linkid');
              ga('send', 'pageview');
              ga('set', 'anonymizeIp', true);
            </script>
        @endif
    </head>
    <body>
        {{ svg_spritesheet() }}
        @if($sidebar !== false)
            @include('menu.sidebar')
        @endif

        <main class="c-main c-main-content--with-menu">
            @if(Auth::check())
                @include('menu.main')
                @include('notifications.general')
            @endif
            <div class="c-main-content">
                @yield('content')
            </div>
        </main>

    </body>
    <script src='{{ asset(env('FILE_PREFIX').elixir("js/app.js"), Request::secure()) }}'></script>
</html>
