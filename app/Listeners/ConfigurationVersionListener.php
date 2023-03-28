<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ConfigurationVersionEvent;
use App\Services\ConfigurationService;

class ConfigurationVersionListener
{
    public function __construct(private readonly ConfigurationService $service)
    {
    }

    public function handle(ConfigurationVersionEvent $event): void
    {
        $data = $event->configuration->toArray();

        $this->service->registerVersion(
            $event->configuration,
            $event->action,
            $event->message,
            $data
        );
    }
}
