@extends('layouts.email-html', [
    'paragraphs' => [
        'Você está recebendo este email porque se cadastrou no sistema do Departamento de Cinema e Vídeo. Se você não realizou um cadastro, ignore este email.',
        'Para confirmar seu email, acesse o link abaixo. Este link é válido por 60 minutos.'
    ]
])