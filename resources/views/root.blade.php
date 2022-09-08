<!DOCTYPE html>
<html lang="pt-BR" class="h-100 min-vh-100 bg-light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Departamento de Cinema e Vídeo da UFF</title>
        <meta name="description" content="Cadastre projetos, reserve equipamentos no almoxarifado e muito mais pelo celular, tablet ou qualquer outro dispositivo com acesso à internet. Sistema para alunos, funcionários ou professores do Departamento de Cinema e Vídeo da Universidade Federal Fluminense.">

        <meta name="robots" content="noindex, nofollow" />
        <meta name="googlebot" content="noindex, nofollow" />

        <style>
            @font-face {
                font-family: 'Gill Sans Nova';
                src: url("{{ asset(mix('/fonts/GillSansNova-Medium.woff2')) }}") format('woff2');
                font-weight: 400;
                font-style: normal;
            }
            
            @font-face {
                font-family: 'Gill Sans Nova';
                src: url("{{ asset(mix('/fonts/GillSansNova-Bold.woff2')) }}") format('woff2');
                font-weight: 700;
                font-style: normal;
            }

            @php(readfile(public_path('/css/critical.css')));
        </style>

        <link rel="icon" href="{{ asset(mix('favicon.ico')) }}" />
        <link rel="icon" href="{{ asset(mix('images/favicon.svg')) }}" type="image/svg+xml" />

        <link href="{{ asset(mix('/fonts/GillSansNova-Medium.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>
        <link href="{{ asset(mix('/fonts/GillSansNova-Bold.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>

        <link rel="preload" href="{{ asset(mix('/css/app.css')) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}"></noscript>
        
        <script async defer src="{{ mix('/js/app.js') }}"></script>      

        @yield('head')
    </head>
    <body class="h-100 bg-light">
        <div id="root" class="position-relative d-flex h-100"></div>

        @include('loading')

        @include('noscript')
    </body>
</html>
