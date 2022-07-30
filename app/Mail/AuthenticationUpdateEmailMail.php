<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class AuthenticationUpdateEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;

    public string $title = 'Atualizar e-mail de acesso';

    public string $urlText = 'Atualizar e-mail';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = env('CLIENT_URL', 'http://localhost:3000') . '/atualizar-email?url=' . \rawurlencode($url);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('naoresponda@cdts.fiocruz.br', 'Portal CDTS')
            ->subject($this->title)
            ->view('emails/authentication-update-email')
            ->text('emails/authentication-update-email-plain');
    }
}
