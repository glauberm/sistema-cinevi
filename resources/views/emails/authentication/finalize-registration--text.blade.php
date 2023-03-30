<x-layout.email-text
    :title="$title"
    :url="$url"
>

Você está recebendo este email porque se cadastrou no sistema do Departamento de Cinema e Vídeo. Se você não realizou 
um cadastro, ignore este email.

Para confirmar seu email, acesse o link abaixo. Este link é válido por 60 minutos.

{{ $url }}

</x-layout.email-text>