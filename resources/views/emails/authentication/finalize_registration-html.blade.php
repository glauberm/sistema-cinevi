<x-layout.email-html
    :title="$title"
    :url="$url"
    :action="$action"
>
    <x-email.paragraph>
        Você está recebendo este email porque se cadastrou no sistema do Departamento de Cinema e Vídeo. Se você não 
        realizou um cadastro, ignore este email.
    </x-email.paragraph>

    <x-email.paragraph>
        Para confirmar seu email, acesse o link abaixo. Este link é válido por 60 minutos.
    </x-email.paragraph>

</x-layout.email-html>