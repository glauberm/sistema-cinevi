<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class BookingCreatedWarehouseMail extends Mailable
{
    use Queueable;

    public string $title = 'Nova Reserva';

    public string $urlText = 'Visualizar reserva';

    public readonly string $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public readonly Booking $booking)
    {
        $this->url = \env('APP_URL').'/reservas/'.$booking->id;
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
            ->view('emails/booking/created-warehouse--html')
            ->text('emails/booking/created-warehouse--text');
    }
}
