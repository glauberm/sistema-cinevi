@extends('layouts.email-notification', [
    'paragraphs' => [
        'Você está recebendo este e-mail porque solicitou uma atualização do seu e-mail de acesso. Se você não solicitou uma atualização, ignore este e-mail.',
        'Para atualizar seu e-mail, acesse o link abaixo. Este link é válido por 60 minutos.'
    ]
])