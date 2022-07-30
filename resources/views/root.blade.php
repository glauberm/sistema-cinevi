<!DOCTYPE html>
<!--................................................-->
<!--................__...............__.............-->
<!--....__.._______/./_..___..____._/.(.)__..____...-->
<!--..././././.___/.__.\/._.\/.__.`/././._.\/.__.\..-->
<!--.././_/././.././_/./..__/./_/./././..__/./././..-->
<!--..\__,_/_/../_.___/\___/\__,_/_/_/\___/_/./_/...-->
<!--................................................-->
<!--......................https://urbealien.dev.....-->
<!--................................................-->
<html lang="pt-BR" class="h-100 min-vh-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />

        <link href="/" rel="preconnect" crossorigin>

        <link rel="icon" href="{{ asset(mix('favicon.ico')) }}" />
        <link rel="icon" href="{{ asset(mix('images/favicon.svg')) }}" type="image/svg+xml" />

        <link href="{{ asset(mix('/fonts/GillSansNova-Medium.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>
        <link href="{{ asset(mix('/fonts/GillSansNova-Bold.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>
        <link href="{{ asset(mix('/fonts/GillSansNova-MediumItalic.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>
        <link href="{{ asset(mix('/fonts/GillSansNova-BoldItalic.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>
        
        <link href="{{ asset(mix('/css/app.css')) }}" rel="stylesheet">
        
        <script async defer src="{{ mix('/js/app.js') }}"></script>

        <style>
            @php(readfile(public_path('/css/critical.css')));
        </style>

        @yield('head')
    </head>
    <body class="h-100">
        <div id="root" class="d-flex h-100"></div>

        @include('loading')

        @include('noscript')
    </body>
</html>
