<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ConfigurationVersionEvent;
use App\Services\ConfigurationService;

class ConfigurationVersionListener
{
    public ConfigurationService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ConfigurationService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param ConfigurationVersionEvent  $event
     * @return void
     */
    public function handle(ConfigurationVersionEvent $event)
    {
        $data = $event->configuration->toArray();

        $this->service->registerVersion($event->configuration, $event->action, $event->message, $data);
    }
}
