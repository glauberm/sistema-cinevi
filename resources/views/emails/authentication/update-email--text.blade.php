@extends('layouts.email-text')

@section('body')

Você está recebendo este email porque solicitou uma atualização do seu email de acesso. Se você não solicitou uma atualização, ignore este email.

Para atualizar seu email, acesse o link abaixo. Este link é válido por 60 minutos.

{{ $url }}

@endsection