<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class BookingCreatedOrUpdatedMail extends Mailable
{
    use Queueable;

    public string $url;

    public string $urlText = 'Visualizar';

    public Booking $booking;

    public string $state;

    public string $title;

    /**
     * Create a new message instance.
     *
     * @param  Booking  $booking
     * @param  string   $state
     * @return void
     */
    public function __construct(Booking $booking, string $state)
    {
        $this->url = \env('APP_URL') . '/reservas/' . $booking->id;

        $this->booking = $booking;

        $this->state = $state;

        if ($state === 'created' || $state === 'created-professor') {
            $this->title = 'Nova Reserva';
        } else {
            $this->title = 'Reserva atualizada';
        }
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

        $mail = $this->from($address, $name)->subject($this->title);

        switch ($this->state) {
            case 'created':
                $mail->view('emails/booking/created')->text('emails/booking/created-plain');
                break;
            case 'updated':
                $mail->view('emails/booking/updated')->text('emails/booking/updated-plain');
                break;
            case 'created-professor':
                $mail->view('emails/booking/created-professor')->text('emails/booking/created-professor-plain');
                break;
            case 'updated-professor':
                $mail->view('emails/booking/updated-professor')->text('emails/booking/updated-professor-plain');
                break;
        }

        return $mail;
    }
}
