<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductionCategoryVersionEvent;
use App\Services\ProductionCategoryService;

class ProductionCategoryVersionListener
{
    public ProductionCategoryService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProductionCategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param ProductionCategoryVersionEvent  $event
     * @return void
     */
    public function handle(ProductionCategoryVersionEvent $event)
    {
        $data = $event->productionCategory->toArray();

        $this->service->registerVersion($event->productionCategory, $event->action, $event->message, $data);
    }
}
