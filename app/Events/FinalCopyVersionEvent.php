<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\FinalCopy;
use Illuminate\Foundation\Events\Dispatchable;

class FinalCopyVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly FinalCopy $finalCopy,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
