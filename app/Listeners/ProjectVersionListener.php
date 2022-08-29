<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProjectVersionEvent;
use App\Services\ProjectService;

class ProjectVersionListener
{
    public ProjectService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param ProjectVersionEvent  $event
     * @return void
     */
    public function handle(ProjectVersionEvent $event)
    {
        $data = $event->project->toArray();

        $this->service->registerVersion($event->project, $event->action, $event->message, $data);
    }
}
