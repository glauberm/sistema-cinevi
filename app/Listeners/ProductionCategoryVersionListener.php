<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductionCategoryVersionEvent;
use App\Services\ProductionCategoryService;

class ProductionCategoryVersionListener
{
    public function __construct(private readonly ProductionCategoryService $service)
    {
    }

    public function handle(ProductionCategoryVersionEvent $event): void
    {
        $data = $event->productionCategory->toArray();

        $this->service->registerVersion($event->productionCategory, $event->action, $event->message, $data);
    }
}
