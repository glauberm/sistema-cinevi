<x-layout.public title="Entrada">
    @include('forms.authentication.login')

    <hr />

    <div class="text-center">
        <a href="{{ route('authentication.request_reset_password') }}" class="btn btn-link">
            Redefinição de senha
        </a>
    </div>
</x-layout.public>