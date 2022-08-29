<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\ProductionCategory;
use Illuminate\Foundation\Events\Dispatchable;

class ProductionCategoryVersionEvent
{
    use Dispatchable;

    public ProductionCategory $productionCategory;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProductionCategory $productionCategory, string $action, string $message)
    {
        $this->productionCategory = $productionCategory;

        $this->action = $action;

        $this->message = $message;
    }
}
