<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\BookableCategory;
use Illuminate\Foundation\Events\Dispatchable;

class BookableCategoryVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly BookableCategory $bookableCategory,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
