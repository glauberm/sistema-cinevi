@extends('layouts.email-html')

@section('content')

    @component('components.paragraph')
        Você está recebendo este email porque solicitou uma atualização do seu email de acesso. Se você não solicitou uma 
        atualização, ignore este email.
    @endcomponent

    @component('components.paragraph')
        Para atualizar seu email, acesse o link abaixo. Este link é válido por 60 minutos.
    @endcomponent

@endsection