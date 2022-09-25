<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UserIsConfirmedMail extends Mailable
{
    use Queueable;

    public string $title = 'Cadastro confirmado';

    public string $urlText = 'Acessar';

    public readonly string $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url = \env('APP_URL').'/entrada';
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
            ->view('emails/user/is-confirmed--html')
            ->text('emails/user/is-confirmed--text');
    }
}
