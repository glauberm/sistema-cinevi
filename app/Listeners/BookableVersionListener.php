<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookableVersionEvent;
use App\Services\BookableService;

class BookableVersionListener
{
    public function __construct(private readonly BookableService $service)
    {
    }

    public function handle(BookableVersionEvent $event): void
    {
        $data = $event->bookable->makeHidden('bookable_category_id')->toArray();

        $data['bookable_category'] = $event->bookable->bookableCategory->toArray();

        $data['users'] = $event->bookable->users->toArray();

        $data['bookings'] = $event->bookable->bookings->toArray();

        $this->service->registerVersion($event->bookable, $event->action, $event->message, $data);
    }
}
