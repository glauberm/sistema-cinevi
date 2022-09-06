@extends('layouts.email-html')

@section('content')

    @component('components.paragraph')
        Você está recebendo este email porque seu cadastro acaba de ser confirmado pelo departamento.
    @endcomponent

    @component('components.paragraph')
        Você já pode acessar o sistema usando o link abaixo.
    @endcomponent

@endsection