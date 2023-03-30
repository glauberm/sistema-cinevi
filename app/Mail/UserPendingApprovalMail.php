<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class UserPendingApprovalMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Novo cadastro';

    public string $action = 'Verificar usuário';

    public readonly string $url;

    public function __construct(public readonly User $user)
    {
        $this->url = route('user.update', ['id' => $user->id]);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/user/pending-approval--html',
            text: 'emails/user/pending-approval--text'
        );
    }
}
