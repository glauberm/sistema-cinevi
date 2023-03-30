<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class UserIsConfirmedMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Cadastro confirmado';

    public string $action = 'Acessar sistema';

    public readonly string $url;

    public function __construct()
    {
        $this->url = route('authentication.index');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/user/is-confirmed--html',
            text: 'emails/user/is-confirmed--text'
        );
    }
}
