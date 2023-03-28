<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProductionRoleVersionEvent;
use App\Services\ProductionRoleService;

class ProductionRoleVersionListener
{
    public function __construct(private readonly ProductionRoleService $service)
    {
    }

    public function handle(ProductionRoleVersionEvent $event): void
    {
        $data = $event->productionRole->toArray();

        $this->service->registerVersion(
            $event->productionRole,
            $event->action,
            $event->message,
            $data
        );
    }
}
