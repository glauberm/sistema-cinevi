<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class AuthenticationResetPasswordMail extends Mailable
{
    use Queueable;

    public string $url;

    public string $urlText = 'Redefinir senha';

    public string $title = 'Redefinição de senha';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = \env('APP_URL') . '/redefinir-senha?url=' . \rawurlencode($url);
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
            ->view('emails/authentication/reset-password')
            ->text('emails/authentication/reset-password-plain');
    }
}
