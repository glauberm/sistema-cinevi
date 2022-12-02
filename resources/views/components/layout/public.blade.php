<x-layout.base :title="$title">

    <div class="row">

        <div class="col-lg-6 offset-lg-1 col-xl-6 offset-xl-1 col-xxl-7 offset-xxl-1 d-flex align-items-center order-1">
            <div class="jumbotron">
                <h1 class="display-4 fw-bolder mb-4 text-warning jumbotron__title">
                    Todos os serviços do departamento em qualquer lugar.
                </h1>

                <p class="fs-4 text-primary">
                    Cadastre projetos, reserve equipamentos no almoxarifado e muito mais pelo celular, tablet ou
                    qualquer outro dispositivo com acesso à internet.
                </p>

                <p class="text-secondary">
                    <strong>
                        Sistema para alunos, funcionários ou professores do Departamento de Cinema e Vídeo da
                        Universidade Federal Fluminense.
                    </strong>
                </p>
            </div>
        </div>

        <div class="col-lg-5 col-xl-5 col-xxl-4 order-0">
            <div class="card mb-5 shadow-lg">

                <div class="card-header bg-warning bg-gradient">
                    <ul class="nav nav-pills nav-fill card-header-pills justify-content-around">
                        <li class="nav-item">
                            <a
                                class="nav-link @if (request()->routeIs('authentication.login')) active @endif"
                                href="{{ route('authentication.login') }}"
                            >
                                Entrada
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link @if (request()->routeIs('authentication.register')) active @endif"
                                href="{{ route('authentication.register') }}"
                            >
                                Cadastro
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <h2 class="visually-hidden">{{ $title }}</h2>

                    @if(Session::has('message'))
                        <x-alert type="{{ Session::get('message-type', 'info');  }}">
                            {{ Session::get('message') }}
                        </x-alert>
                    @endif
                    
                    {{ $slot }}
                </div>

            </div>
        </div>

    </div>

</x-layout.base>
