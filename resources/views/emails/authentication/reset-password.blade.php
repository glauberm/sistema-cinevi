@extends('layouts.email-html', [
    'paragraphs' => [
        'Você está recebendo este email porque solicitou uma redefinição de senha. Se você não solicitou uma redefinição, ignore este email.',
        'Para redefinir sua senha, acesse o link abaixo. Este link é válido por 60 minutos.'
    ]
])
