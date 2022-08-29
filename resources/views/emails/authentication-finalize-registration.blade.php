@extends('layouts.email-notification', [
    'paragraphs' => [
        'Você está recebendo este e-mail porque se cadastrou no sistema do Departamento de Cinema e Vídeo. Se você não realizou um cadastro, ignore este e-mail.',
        'Para confirmar seu e-mail, acesse o link abaixo. Este link é válido por 60 minutos.'
    ]
])