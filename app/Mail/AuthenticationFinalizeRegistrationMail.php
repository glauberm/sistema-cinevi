<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class AuthenticationFinalizeRegistrationMail extends Mailable
{
    use Queueable;

    public string $title = 'Confirmação de email';

    public string $action = 'Confirmar email';

    public function __construct(public string $url)
    {
        $this->url = route('authentication.finalize_registration');
    }

    public function envelope(): Envelope
    {
        /** @var string $address */
        $address = env('MAIL_FROM_ADDRESS');

        /** @var string $name */
        $name = env('MAIL_FROM_NAME');

        return new Envelope(
            from: new Address($address, $name),
            subject: $this->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/authentication/finalize_registration-html',
            text: 'emails/authentication/finalize_registration-text'
        );
    }
}
