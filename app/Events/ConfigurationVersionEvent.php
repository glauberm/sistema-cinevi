<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Configuration;
use Illuminate\Foundation\Events\Dispatchable;

class ConfigurationVersionEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Configuration $configuration,
        public readonly string $action,
        public readonly string $message
    ) {
    }
}
