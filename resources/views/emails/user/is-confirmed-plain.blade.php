@extends('layouts.email-plain')

@section('body')

Você está recebendo este email porque seu cadastro acaba de ser confirmado pelo departamento.

Você já pode acessar o sistema usando o link abaixo.

{{ $url }}

@endsection