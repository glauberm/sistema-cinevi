<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookingVersionEvent;
use App\Services\BookingService;

class BookingVersionListener
{
    public BookingService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param BookingVersionEvent  $event
     * @return void
     */
    public function handle(BookingVersionEvent $event)
    {
        $data = $event->booking->toArray();

        $this->service->registerVersion($event->booking, $event->action, $event->message, $data);
    }
}
