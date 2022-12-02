<form
    method="{{ $method ?? 'POST'}}"
    action="{{ $action }}"
>
    @csrf

    @if($errors->any())
        <x-alert type="danger">
            Há erros nos dados informados.
        </x-alert>
    @endif

    {{ $slot }}
</form>
