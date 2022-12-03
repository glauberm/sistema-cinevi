<x-form.form
    method="POST"
    action="{{ route('authentication.register-action') }}"
>

    <x-form.input
        label="Senha"
        name="password"
        type="password"
        :messages="['Maiúsculas e minúsculas', 'Mínimo 12 caracteres']"
    />

    <x-form.input
        label="Confirmar senha"
        name="password_confirmation"
        type="password"
        :messages="['Maiúsculas e minúsculas', 'Mínimo 12 caracteres']"
    />

    <div class="d-grid gap-2">
        <x-form.button
            type="submit"
            class="btn btn-lg btn-primary"
        >
            Redefinir senha
        </x-form.button>
    </div>

</x-form.form>