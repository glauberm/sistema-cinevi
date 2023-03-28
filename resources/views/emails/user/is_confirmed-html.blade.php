@extends('layout.email-html')

@section('content')

    @component('components.email.paragraph')
        Você está recebendo este email porque seu cadastro acaba de ser confirmado pelo departamento.
    @endcomponent

    @component('components.email.paragraph')
        Você já pode acessar o sistema usando o link abaixo.
    @endcomponent

@endsection