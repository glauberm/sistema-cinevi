<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class AuthenticationResetPasswordMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Redefinição de senha';

    public string $action = 'Redefinir senha';

    public function __construct(public readonly string $url)
    {
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/authentication/reset-password--html',
            text: 'emails/authentication/reset-password--text'
        );
    }
}
