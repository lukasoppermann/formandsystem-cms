<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>{{$title or 'Focus on the important parts, leave the rest to us'}} – Form&System</title>
        <meta http-equiv="content-language" content="en">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
        <meta name="theme-color" content="rgb(255,210,0)">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="site_url" content="{{ url('/') }}">
        <link href="{{ asset(env('FILE_PREFIX').elixir('css/app.css'), Request::secure()) }}" rel="stylesheet" type="text/css">

        @include('custom-css')
        <link href='//fonts.googleapis.com/css?family=Merriweather:300,700%7CLato:400,700&subset=latin,latin' rel='stylesheet' type='text/css'>

        @if (env('APP_ENV') !== 'local')
            <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
              ga('create', 'UA-7074034-24', 'auto');
              ga('require', 'linkid');
              ga('send', 'pageview');
              ga('set', 'anonymizeIp', true);

            </script>
        @endif
    </head>
    <body>
        <?php include('./'.elixir("svgs/svg-sprite.svg")); ?>
        {!!$app['Nav']->render()!!}

        <main class="c-main-content">
            @include('notice.dialog')
            @include('notice.status')
            @yield('content')
        </main>
    </body>
    <script src='{{ asset(env('FILE_PREFIX').elixir("js/app.js"), Request::secure()) }}'></script>
</html>
