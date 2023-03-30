<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\BookableCategoryVersionEvent;
use App\Services\BookableCategoryService;

class BookableCategoryVersionListener
{
    public function __construct(private readonly BookableCategoryService $service)
    {
    }

    public function handle(BookableCategoryVersionEvent $event): void
    {
        $data = $event->bookableCategory->toArray();

        $this->service->registerVersion(
            $event->bookableCategory,
            $event->action,
            $event->message,
            $data
        );
    }
}
