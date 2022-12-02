@php(
    $menuItems = [
        [
            'label' => 'Acesso',
            'links' => [
                [
                    'to' => '',
                    'text' => 'Sua área',
                ],
                // [
                //     'to' => '/comunidade',
                //     'text' => 'Comunidade',
                // ],
                [
                    'to' => '',
                    'text' => 'Saída',
                ],
            ],
        ],
        [
            'label' => 'Sistema',
            'links' => [
                [
                    'to' => '',
                    'text' => 'Usuários',
                ],
                [
                    'to' => '',
                    'text' => 'Configurações',
                ],
            ],
        ],
        [
            'label' => 'Almoxarifado',
            'links' => [
                [
                    'to' => '',
                    'text' => 'Reservas',
                ],
                [
                    'to' => '',
                    'text' => 'Reserváveis',
                ],
                [
                    'to' => '',
                    'text' => 'Categorias',
                ],
            ],
        ],
        [
            'label' => 'Realização',
            'links' => [
                [
                    'to' => '',
                    'text' => 'Projetos',
                ],
                // [
                //     'to' => finalCopy.index.path,
                //     'text' => 'Cópias Finais',
                // ],
                [
                    'to' => '',
                    'text' => 'Funções',
                ],
                [
                    'to' => '',
                    'text' => 'Modalidades',
                ],
            ],
        ],
    ]
)

<nav class="pt-2 sticky-top vh-100 overflow-auto">
    <h2 class="visually-hidden">Menu</h2>
    @foreach ($menuItems as $menuItem)
        <div class="card mb-4">
            <h3 class="card-header bg-warning bg-gradient h5">
                <span class="text-dark text-opacity-75">{{ $menuItem['label'] }}</span>
            </h3>
            <ul class="list-group list-group-flush">
                @foreach ($menuItem['links'] as $link)
                    <li class="list-group-item list-group-flush p-0">
                        <a
                            href="{{ $link['to'] }}"
                            class="
                                ps-4 text-primary list-group-item list-group-item-action
                                @if (request()->routeIs('authentication.login')) active @endif
                            "
                            @if (request()->routeIs('authentication.login')) aria-current="true" @endif
                        >
                            {{ $link['text'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</nav>
