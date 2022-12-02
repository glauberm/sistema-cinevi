<x-form.form
    method="POST"
    action="{{ route('authentication.login-action') }}"
>

    <x-form.input
        label="Email"
        name="email"
        type="email"
    />

    <x-form.input
        label="Senha"
        name="password"
        type="password"
    />

    <div class="d-grid gap-2">
        <x-form.button
            type="submit"
            class="btn btn-lg btn-primary"
        >
            Entrar
        </x-form.button>
    </div>

</x-form.form>