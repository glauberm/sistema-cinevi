<x-form.form
    method="POST"
    action="{{ route('authentication.register--action') }}"
>

    <x-form.input
        label="Título"
        name="title"
        type="text"
    />

    <x-form.textarea
        label="Descrição"
        name="description"
    />

    <x-form.button
        type="submit"
        class="btn btn-lg btn-primary"
    >
    @switch($action)
        @case('add')
            Criar
            @break
        @case('edit')
            Editar
            @break
    @endswitch
    </x-form.button>

</x-form.form>