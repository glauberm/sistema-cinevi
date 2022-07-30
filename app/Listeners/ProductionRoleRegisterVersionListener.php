<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductionRoleRegisterVersionEvent;
use App\Services\ProductionRoleService;

class ProductionRoleRegisterVersionListener
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
     * @param ProductionRoleRegisterVersionEvent  $event
     * @return void
     */
    public function handle(ProductionRoleRegisterVersionEvent $event)
    {
        $data = $event->productionRole->makeHidden('deleted_at')->toArray();

        $this->service->registerVersion($event->productionRole, $event->action, $event->message, $data);
    }
}
