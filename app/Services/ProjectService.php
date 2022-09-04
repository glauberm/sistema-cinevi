<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ProjectUserRole;
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

    /**
     * @param  integer                 $id
     * @return Project
     */
    public function get(int $id): Project
    {
        return $this->modelClass::with([
            'owner',
            'productionCategory',
            'professor',
            'directors',
            'producers',
            'photographyDirectors',
            'soundDirectors',
            'artDirectors'
        ])
            ->findOrFail($id);
    }

    /**
     * @param  Project              $project
     * @param  array<string,mixed>  $data
     * @return Project
     */
    public function afterCreated(Project $project, array $data): Project
    {
        /** @var array<int,array<string,mixed>> */
        $directors = $data['directors'];

        /** @var array<int,array<string,mixed>> */
        $producers = $data['producers'];

        /** @var array<int,array<string,mixed>> */
        $photographyDirectors = $data['photography_directors'];

        /** @var array<int,array<string,mixed>> */
        $soundDirectors = $data['sound_directors'];

        /** @var array<int,array<string,mixed>> */
        $artDirectors = $data['art_directors'];

        $project->directors()->attach(
            \array_column($directors, 'id'),
            ['role' => ProjectUserRole::Director]
        );

        $project->producers()->attach(
            \array_column($producers, 'id'),
            ['role' => ProjectUserRole::Producer]
        );

        $project->photographyDirectors()->attach(
            \array_column($photographyDirectors, 'id'),
            ['role' => ProjectUserRole::PhotographyDirector]
        );

        $project->soundDirectors()->attach(
            \array_column($soundDirectors, 'id'),
            ['role' => ProjectUserRole::SoundDirector]
        );

        $project->artDirectors()->attach(
            \array_column($artDirectors, 'id'),
            ['role' => ProjectUserRole::ArtDirector]
        );

        return $project;
    }

    /**
     * @param  Project              $project
     * @param  array<string,mixed>  $data
     * @return void
     */
    public function afterUpdated(Project $project, array $data): void
    {
        /** @var array<int,array<string,mixed>> */
        $directors = $data['directors'];

        /** @var array<int,array<string,mixed>> */
        $producers = $data['producers'];

        /** @var array<int,array<string,mixed>> */
        $photographyDirectors = $data['photography_directors'];

        /** @var array<int,array<string,mixed>> */
        $soundDirectors = $data['sound_directors'];

        /** @var array<int,array<string,mixed>> */
        $artDirectors = $data['art_directors'];

        $project->directors()->syncWithPivotValues(
            \array_column($directors, 'id'),
            ['role' => ProjectUserRole::Director]
        );

        $project->producers()->syncWithPivotValues(
            \array_column($producers, 'id'),
            ['role' => ProjectUserRole::Producer]
        );

        $project->photographyDirectors()->syncWithPivotValues(
            \array_column($photographyDirectors, 'id'),
            ['role' => ProjectUserRole::PhotographyDirector]
        );

        $project->soundDirectors()->syncWithPivotValues(
            \array_column($soundDirectors, 'id'),
            ['role' => ProjectUserRole::SoundDirector]
        );

        $project->artDirectors()->syncWithPivotValues(
            \array_column($artDirectors, 'id'),
            ['role' => ProjectUserRole::ArtDirector]
        );
    }
}
