<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="Lukas Oppermann – vea.re" />
  <meta name="description" content="{{Config::get('data.description', 'The portfolio of freelance designer Lukas Oppermann, interface design, print design, branding & information graphics')}}" />
  <meta name="robots" content="index,follow" />
  <meta name="language" content="en" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1,maximum-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="stylesheet" href="{{{asset('css/app.css')}}}">
  <!-- <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> -->
  <!-- <link href='http://fonts.googleapis.com/css?family=Roboto:500,300' rel='stylesheet' type='text/css'> -->
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
  <title>{{$title or ''}} | Form&System</title>
</head>
<body>
  <?php include("./media/svg-sprite.svg"); ?>

  @if( isset($error) )
    @include('misc.error', array('error' => $error))
  @endif

  @include('partials/navigation')

  <div class="content-body">
    @yield('content','')
  </div>

  {{--<script data-main="{{asset('/js/main')}}" src="{{asset('/js/bower_components/requirejs/require.js')}}"></script>--}}
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="{{asset('/js/app.js')}}"></script>
</body>
</html>
