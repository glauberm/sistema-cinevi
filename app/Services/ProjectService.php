<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\ProjectVersionEvent;
use App\Models\Project;

class ProjectService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Project::class;

    protected string $modelVersionEventClass = ProjectVersionEvent::class;

    protected string $modelVersionTableName = 'projects_versions';

    protected string $modelVersionIdColumnName = 'project_id';
}
