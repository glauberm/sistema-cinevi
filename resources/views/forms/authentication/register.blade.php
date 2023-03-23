<x-form.form
    method="POST"
    action="{{ route('authentication.register-action') }}"
>

    <x-form.input
        label="Nome completo"
        name="name"
        type="text"
    />

    <div class="row">
        <div class="col-lg">
            <x-form.input
                label="Matrícula ou SIAPE"
                name="identifier"
                type="text"
                numeric
                maxlength="9"
                :messages="['Somente números', 'Entre 7 e 9 dígitos']"
            />
        </div>
        <div class="col-lg">
            <x-form.input
                label="Telefone"
                name="phone"
                type="tel"
                numeric
                maxlength="11"
                :messages="['Somente números', 'Entre 10 e 11 dígitos, com DDD']"
            />
        </div>
    </div>

    <x-form.input
        label="Email"
        name="email"
        type="email"
    />

    <x-form.input
        label="Senha"
        name="password"
        type="password"
        :messages="['Maiúsculas e minúsculas', 'Mínimo 12 caracteres']"
    />

    <div class="d-grid gap-2">
        <x-form.button
            type="submit"
            class="btn btn-lg btn-primary"
        >
            Cadastrar
        </x-form.button>
    </div>

</x-form.form>