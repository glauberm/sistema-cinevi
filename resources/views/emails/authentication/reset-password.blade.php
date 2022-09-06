@extends('layouts.email-html')

@section('content')

    @component('components.paragraph')
        Você está recebendo este email porque solicitou uma redefinição de senha. Se você não solicitou uma redefinição, 
        ignore este email.
    @endcomponent

    @component('components.paragraph')
        Para redefinir sua senha, acesse o link abaixo. Este link é válido por 60 minutos.
    @endcomponent

@endsection