<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookableVersionEvent;
use App\Services\BookableService;

class BookableVersionListener
{
    public BookableService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BookableService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param BookableVersionEvent  $event
     * @return void
     */
    public function handle(BookableVersionEvent $event)
    {
        $data = $event->bookable->toArray();

        $this->service->registerVersion($event->bookable, $event->action, $event->message, $data);
    }
}
