<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Booking;
use Illuminate\Foundation\Events\Dispatchable;

class BookingVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Booking $booking,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
