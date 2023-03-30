<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class BookableWithReturnOverdueMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Reservável com devolução atrasada';

    public string $action = 'Visualizar reserva';

    public readonly string $url;

    public function __construct(
        public readonly Bookable $bookable,
        public readonly Booking $booking,
    ) {
        $this->url = route('booking.update', ['id' => $booking->id]);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails/bookable/return-overdue--html',
            text: 'emails/bookable/return-overdue--text'
        );
    }
}
