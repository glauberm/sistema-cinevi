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

        <div id="loading">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                width="400"
                height="400"
                viewBox="0 0 32 32"
                class="animated-favicon"
            >
                <g class="animated-favicon__cine">
                    <path
                        class="animated-favicon__ci"
                        d="m3.1522 12.687c-0.94446 0-1.7042 0.30809-2.2833 0.92424-0.57832 0.61618-0.86972 1.4269-0.86884 2.4321 0 0.99553 0.29576 1.7896 0.88812 2.3819 0.5968 0.59241 1.3961 0.88812 2.3961 0.88812 0.60649 0 1.2279-0.11883 1.8626-0.35474v-1.2491c-0.62939 0.28256-1.1892 0.4234-1.6752 0.4234-0.6716 0-1.206-0.19365-1.6038-0.57744-0.39347-0.38467-0.59153-0.90137-0.59153-1.5545 0-0.62057 0.18397-1.1311 0.55015-1.5289 0.36618-0.40315 0.8336-0.60473 1.4031-0.60473 0.54663 0 1.1382 0.20598 1.7772 0.61354v-1.3477c-0.38467-0.17165-0.70684-0.28608-0.97091-0.34681-0.25968-0.06514-0.55456-0.09859-0.88291-0.09859zm3.5404 0.12676v6.3869h1.2622v-6.3869z"
                    />
                    <path
                        class="animated-favicon__ne"
                        d="m13.242 12.687c-0.71884 0-1.3636 0.31399-1.9289 0.94019v-0.81324h-1.293v6.4001h1.293v-4.5697c0.41718-0.598 0.92612-0.8988 1.5241-0.8988 0.46834 0 0.80351 0.14112 1.0037 0.42424 0.19933 0.27871 0.29723 0.74352 0.29812 1.3971v3.6462h1.2683v-3.6603c0-0.7797-0.09172-1.346-0.27254-1.7031-0.1764-0.36162-0.43395-0.64472-0.77706-0.84848-0.3431-0.20903-0.71444-0.31399-1.1131-0.31399zm6.684 0c-0.88108 0-1.5982 0.30782-2.1495 0.92078-0.55213 0.6077-0.83002 1.3962-0.83002 2.3708 0 0.64918 0.13142 1.2234 0.39161 1.7199 0.2646 0.49216 0.61388 0.88466 1.0504 1.1766 0.43571 0.29194 1.0063 0.43836 1.712 0.43836 0.51509 0 0.9623-0.05645 1.3424-0.16847 0.38544-0.11114 0.77355-0.29723 1.1634-0.55655v-1.2375c-0.7047 0.5195-1.4747 0.7797-2.31 0.7797-0.598 0-1.0884-0.18082-1.4695-0.54331-0.37574-0.36162-0.57948-0.85112-0.6121-1.4632h4.5008v-0.15964c0-0.99754-0.25225-1.7931-0.75759-2.3867-0.50538-0.59359-1.1828-0.88988-2.0313-0.88988zm0 1.0999c0.45424 0 0.81676 0.13671 1.0858 0.41101 0.26901 0.27342 0.41984 0.66325 0.45246 1.1687h-3.222c0.0882-0.50538 0.27431-0.89522 0.56272-1.1687 0.29194-0.27342 0.66676-0.41101 1.1219-0.41101z"
                    />
                </g>
                <path
                    class="animated-favicon__vi"
                    d="m23.379 12.687 2.9444 6.6262h0.43165l2.8744-6.6262h-1.3964l-1.6907 4.0078-1.7553-4.0078zm7.331 0v6.5144h1.2904v-6.5144h-1.2896z"
                />
            </svg>
        </div>

        <noscript>
            <div id="noscript" class="d-flex vw-100 vh-100 position-absolute top-0 align-items-center justify-content-center p-5 bg-danger">
                <p class="lead text-center text-white">
                    Este app requere JavaScript para funcionar.
                </p>
            </div>
        </noscript>
    </body>
</html>
