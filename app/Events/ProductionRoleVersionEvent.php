<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\ProductionRole;
use Illuminate\Foundation\Events\Dispatchable;

class ProductionRoleVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly ProductionRole $productionRole,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
