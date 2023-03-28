<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;

class BookingCreatedWarehouseMail extends AbstractMail
{
    use Queueable;

    public string $title = 'Nova Reserva';

    public string $action = 'Visualizar reserva';

    public readonly string $url;

    public function __construct(public readonly Booking $booking)
    {
        $this->url = route('booking.update', ['id' => $booking->id]);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/booking/created-warehouse-html',
            text: 'emails/booking/created-warehouse-text'
        );
    }
}
