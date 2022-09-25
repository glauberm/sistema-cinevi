<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProjectVersionEvent;
use App\Services\ProjectService;

class ProjectVersionListener
{
    public function __construct(private readonly ProjectService $service)
    {
    }

    public function handle(ProjectVersionEvent $event): void
    {
        $data = $event->project->toArray();

        $data['owner'] = $event->project->owner->toArray();

        $data['production_category'] = $event->project->productionCategory->toArray();

        $data['professor'] = $event->project->professor->toArray();

        $data['directors'] = $event->project->directors->toArray();

        $data['producers'] = $event->project->producers->toArray();

        $data['photography_directors'] = $event->project->photographyDirectors->toArray();

        $data['sound_directors'] = $event->project->soundDirectors->toArray();

        $data['art_directors'] = $event->project->artDirectors->toArray();

        $this->service->registerVersion($event->project, $event->action, $event->message, $data);
    }
}
