<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class AuthenticationResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;

    public string $title = 'Redefinição de senha';

    public string $urlText = 'Redefinir senha';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = env('CLIENT_URL', 'http://localhost:3000') . '/redefinir-senha?url=' . \rawurlencode($url);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nao-responda@cinemauff.com.br', 'Departamento de Cinema e Vídeo da UFF')
            ->subject($this->title)
            ->view('emails/authentication-reset-password')
            ->text('emails/authentication-reset-password-plain');
    }
}
