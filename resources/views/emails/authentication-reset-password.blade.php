@extends('layouts.email-notification', [
    'paragraphs' => [
        'Você está recebendo este e-mail porque solicitou uma redefinição de senha. Se você não solicitou uma redefinição, ignore este e-mail.',
        'Para redefinir sua senha, acesse o link abaixo. Este link é válido por 60 minutos.'
    ]
])
