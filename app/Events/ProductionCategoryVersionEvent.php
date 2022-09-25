<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\ProductionCategory;
use Illuminate\Foundation\Events\Dispatchable;

class ProductionCategoryVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly ProductionCategory $productionCategory,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
