<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ProjectUserRole;
use App\Events\ProjectVersionEvent;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProjectService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::get as baseGet;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Project::class;

    protected string $modelVersionEventClass = ProjectVersionEvent::class;

    protected string $modelVersionTableName = 'projects_versions';

    protected string $modelVersionIdColumnName = 'project_id';

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @param  string[]  $relations
     */
    public function get(int $id, array $relations = [
        'owner',
        'productionCategory',
        'professor',
        'directors',
        'producers',
        'photographyDirectors',
        'soundDirectors',
        'artDirectors',
    ]): Project
    {
        /** @var Project $project */
        $project = $this->baseGet($id, $relations);

        return $project;
    }

    /**
     * @param  Builder<Project>  $query
     * @return Builder<Project>
     */
    protected function beforePagination(Builder $query, Request $request): Builder
    {
        if (is_string($request->input('status'))) {
            switch ($request->input('status')) {
                case 'owned_only':
                    $query->where(
                        'owner_id',
                        '=',
                        $this->authService->getAuthIdOrFail()
                    );
                    break;
            }
        }

        return $query;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterCreated(Project $project, array $data): Project
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
            array_column($directors, 'id'),
            ['role' => ProjectUserRole::Director]
        );

        $project->producers()->attach(
            array_column($producers, 'id'),
            ['role' => ProjectUserRole::Producer]
        );

        $project->photographyDirectors()->attach(
            array_column($photographyDirectors, 'id'),
            ['role' => ProjectUserRole::PhotographyDirector]
        );

        $project->soundDirectors()->attach(
            array_column($soundDirectors, 'id'),
            ['role' => ProjectUserRole::SoundDirector]
        );

        $project->artDirectors()->attach(
            array_column($artDirectors, 'id'),
            ['role' => ProjectUserRole::ArtDirector]
        );

        return $project;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterUpdated(Project $project, array $data): void
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
            array_column($directors, 'id'),
            ['role' => ProjectUserRole::Director]
        );

        $project->producers()->syncWithPivotValues(
            array_column($producers, 'id'),
            ['role' => ProjectUserRole::Producer]
        );

        $project->photographyDirectors()->syncWithPivotValues(
            array_column($photographyDirectors, 'id'),
            ['role' => ProjectUserRole::PhotographyDirector]
        );

        $project->soundDirectors()->syncWithPivotValues(
            array_column($soundDirectors, 'id'),
            ['role' => ProjectUserRole::SoundDirector]
        );

        $project->artDirectors()->syncWithPivotValues(
            array_column($artDirectors, 'id'),
            ['role' => ProjectUserRole::ArtDirector]
        );
    }

    public function isOwnedBy(int $id, User $user): bool
    {
        $project = $this->modelClass::with(['owner'])->findOrFail($id);

        return $project->owner->id === $user->id;
    }
}
