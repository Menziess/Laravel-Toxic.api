<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=0, initial-scale=1.0, minimum-scale=1, maximum-scale=1">

    <!-- Tokens -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api_token" content="{{ Helpers::api_token() }}" id="api_token">
    <meta name="domain_ext" content="{{ Config::get('services.server.php_self') }}" id="domain_ext">

    <!-- Title -->
    <title>{{ config('app.name', 'Toxic') }}</title>
    <meta name="description" content="Truth never damages a cause that is just." />
    <meta property="og:description" content="Truth never damages a cause that is just." />
    <meta property="og:image" content="{{ asset('img/Toxic-logo.png') }}" />
    <meta property="og:title" content="There Be Free Speech Without Limits" />
    <meta property="fb:app_id" content="297069167386750" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicons/apple-touch-icon.png') }}" type="image/x-icon" />
    <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    
    <meta name="apple-mobile-web-app-title" content="T-o-x-i-c">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="theme-color" content="#ffffff">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    @yield('head')
</head>
<body ontouchstart="">
    <div id="app" style="margin-bottom: 20vh;">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script async defer>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-102304414-1', 'auto');ga('send', 'pageview');
    </script>
</body>
</html>
