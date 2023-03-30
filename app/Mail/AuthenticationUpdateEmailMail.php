<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class AuthenticationUpdateEmailMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Atualizar email de acesso';

    public string $action = 'Atualizar email';

    public function __construct(public readonly string $url)
    {
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/authentication/update-email--html',
            text: 'emails/authentication/update-email--text'
        );
    }
}
