<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

abstract class AbstractMail extends Mailable
{
    public string $title;

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
}
