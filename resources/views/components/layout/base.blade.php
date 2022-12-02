<!DOCTYPE html>
<html lang="pt-BR" class="h-100 min-vh-100 bg-light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            @if($title)
                {{ $title }} - Departamento de Cinema e Vídeo da UFF
            @else
                Departamento de Cinema e Vídeo da UFF
            @endif
        </title>

        <meta name="description" content="Cadastre projetos, reserve equipamentos no almoxarifado e muito mais pelo celular, tablet ou qualquer outro dispositivo com acesso à internet. Sistema para alunos, funcionários ou professores do Departamento de Cinema e Vídeo da Universidade Federal Fluminense.">

        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">

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
        </style>

        <link rel="icon" href="{{ asset(mix('favicon.ico')) }}" />
        <link rel="icon" href="{{ asset(mix('images/favicon.svg')) }}" type="image/svg+xml" />

        <link href="{{ asset(mix('/fonts/GillSansNova-Medium.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>
        <link href="{{ asset(mix('/fonts/GillSansNova-Bold.woff2')) }}" rel="preload" type="font/woff2" as="font" crossorigin>

        <link rel="preload" href="{{ asset(mix('/css/index.css')) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset(mix('/css/index.css')) }}"></noscript>
        
        <script defer src="{{ mix('/js/index.js') }}"></script>      
    </head>
    <body class="h-100 bg-light">
        <div class="d-flex w-100 h-100 pt-5 pb-3 mx-auto flex-column">

            <header class="mb-auto">
                <div class="container mx-auto text-center">
                    <a
                        class="d-inline-block"
                        href="
                            @if (Auth::check())
                                {{ route('authentication.index') }}
                            @else
                                {{ route('authentication.login') }}
                            @endif
                        "
                    >
                        <x-svg.logo />
                    </a>
                </div>
            </header>

            <main class="py-5">
                <div class="container">
                    {{ $slot }}
                </div>
            </main>

            <br class="d-none" />

            <footer class="mt-auto text-secondary">
                <div class="container text-center mb-4">
                    <a
                        href="https://uff.br/"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <x-svg.uff />
                    </a>
                </div>
            </footer>
            
        </div>
    </body>
</html>