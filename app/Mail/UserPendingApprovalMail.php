<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UserPendingApprovalMail extends Mailable
{
    use Queueable;

    public string $title = 'Novo cadastro pendente de aprovação';

    public string $urlText = 'Verificar usuário';

    public readonly string $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->url = \env('APP_URL').'/usuarios/'.$user->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /** @var string $address */
        $address = env('MAIL_FROM_ADDRESS');

        /** @var string $name */
        $name = env('MAIL_FROM_NAME');

        return $this->from($address, $name)
            ->subject($this->title)
            ->view('emails/user/pending-approval--html')
            ->text('emails/user/pending-approval--text');
    }
}
