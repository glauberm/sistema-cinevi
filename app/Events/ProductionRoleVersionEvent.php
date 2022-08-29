<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\ProductionRole;
use Illuminate\Foundation\Events\Dispatchable;

class ProductionRoleVersionEvent
{
    use Dispatchable;

    public ProductionRole $productionRole;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProductionRole $productionRole, string $action, string $message)
    {
        $this->productionRole = $productionRole;

        $this->action = $action;

        $this->message = $message;
    }
}
