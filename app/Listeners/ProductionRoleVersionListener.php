<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductionRoleVersionEvent;
use App\Services\ProductionRoleService;

class ProductionRoleVersionListener
{
    public ProductionRoleService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProductionRoleService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param ProductionRoleVersionEvent  $event
     * @return void
     */
    public function handle(ProductionRoleVersionEvent $event)
    {
        $data = $event->productionRole->toArray();

        $this->service->registerVersion($event->productionRole, $event->action, $event->message, $data);
    }
}
