<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;

class BookableUnderMaintenanceMail extends DefaultMailable
{
    use Queueable;

    public string $title = 'Reservável sob manutenção';

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
            view: 'emails/bookable/under-maintenance--html',
            text: 'emails/bookable/under-maintenance--text'
        );
    }
}