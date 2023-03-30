<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class AuthenticationFinalizeRegistrationMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Confirmação de email';

    public string $action = 'Confirmar email';

    public function __construct(public readonly string $url)
    {
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/authentication/finalize-registration--html',
            text: 'emails/authentication/finalize-registration--text'
        );
    }
}
