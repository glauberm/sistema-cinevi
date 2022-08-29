<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookableCategoryVersionEvent;
use App\Services\BookableCategoryService;

class BookableCategoryVersionListener
{
    public BookableCategoryService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BookableCategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param BookableCategoryVersionEvent  $event
     * @return void
     */
    public function handle(BookableCategoryVersionEvent $event)
    {
        $data = $event->bookableCategory->toArray();

        $this->service->registerVersion($event->bookableCategory, $event->action, $event->message, $data);
    }
}
