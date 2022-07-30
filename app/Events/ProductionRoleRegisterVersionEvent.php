<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\ProductionRole;

class ProductionRoleRegisterVersionEvent
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
