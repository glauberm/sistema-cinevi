<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Project;
use Illuminate\Foundation\Events\Dispatchable;

class ProjectVersionEvent
{
    use Dispatchable;

    public Project $project;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Project $project, string $action, string $message)
    {
        $this->project = $project;

        $this->action = $action;

        $this->message = $message;
    }
}
