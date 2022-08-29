<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Booking;
use Illuminate\Foundation\Events\Dispatchable;

class BookingVersionEvent
{
    use Dispatchable;

    public Booking $booking;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, string $action, string $message)
    {
        $this->booking = $booking;

        $this->action = $action;

        $this->message = $message;
    }
}
