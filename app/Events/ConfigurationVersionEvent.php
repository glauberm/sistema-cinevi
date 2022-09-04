<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Configuration;
use Illuminate\Foundation\Events\Dispatchable;

class ConfigurationVersionEvent
{
    use Dispatchable;

    public configuration $configuration;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Configuration $configuration, string $action, string $message)
    {
        $this->configuration = $configuration;

        $this->action = $action;

        $this->message = $message;
    }
}
