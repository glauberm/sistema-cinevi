<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookingVersionEvent;
use App\Services\BookingService;

class BookingVersionListener
{
    public function __construct(private readonly BookingService $service)
    {
    }

    public function handle(BookingVersionEvent $event): void
    {
        $data = $event->booking->toArray();

        $data['owner'] = $event->booking->owner->toArray();

        $data['project'] = $event->booking->project->toArray();

        $data['bookables'] = $event->booking->bookables->toArray();

        $this->service->registerVersion($event->booking, $event->action, $event->message, $data);
    }
}
