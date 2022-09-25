<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Bookable;
use Illuminate\Foundation\Events\Dispatchable;

class BookableVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Bookable $bookable,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
