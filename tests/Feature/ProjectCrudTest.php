<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\ProductionCategory;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class ProjectCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'projetos';
    }

    protected function getCreateRoute(): string
    {
        return 'projetos/adicionar';
    }

    protected function getCreateData(): array
    {
        $owner = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $professor = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Professor]])
            ->createOne();

        $productionCategory = ProductionCategory::factory()
            ->createOne();

        return [
            'title' => 'Lorem Ipsum',
            'synopsis' => 'Lorem ipsum dolor sit amet',
            'genres' => 'Lorem, Ipsum',
            'capture_format' => 'Lorem Ipsum',
            'capture_notes' => 'Lorem ipsum dolor sit amet',
            'venues' => 'Lorem ipsum dolor sit amet',
            'pre_production_date' => '2025-02-16',
            'production_date' => '2025-02-17',
            'post_production_date' => '2025-02-18',
            'has_attended_photography_discipline' => true,
            'has_attended_sound_discipline' => true,
            'has_attended_art_discipline' => true,
            'owner_id' => $owner->id,
            'production_category_id' => $productionCategory->id,
            'professor_id' => $professor->id,
            'directors' => [
                ['id' => $owner->id],
            ],
            'producers' => [
                ['id' => $owner->id],
            ],
            'photography_directors' => [
                ['id' => $owner->id],
            ],
            'sound_directors' => [
                ['id' => $owner->id],
            ],
            'art_directors' => [
                ['id' => $owner->id],
            ],
        ];
    }

    protected function getCreatedData(array $createData): array
    {
        return [
            ...Arr::except($createData, [
                'directors',
                'producers',
                'photography_directors',
                'sound_directors',
                'art_directors'
            ]),
            'has_attended_photography_discipline' => 1,
            'has_attended_sound_discipline' => 1,
            'has_attended_art_discipline' => 1,
        ];
    }

    protected function additionalCreateAssertions(): void
    {
        $this->assertDatabaseCount('project_user', 5);

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'director']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'producer']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'photography-director']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'sound-director']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'art-director']
        );
    }

    protected function getUpdateRoute(): string
    {
        $project = Project::factory()
            ->createOne();

        return "projetos/{$project->id}/editar";
    }

    protected function getUpdateData(): array
    {
        $owner = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $professor = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Professor]])
            ->createOne();

        $productionCategory = ProductionCategory::factory()
            ->createOne();

        return [
            'title' => 'Lorem Ipsum',
            'synopsis' => 'Lorem ipsum dolor sit amet',
            'genres' => 'Lorem, Ipsum',
            'capture_format' => 'Lorem Ipsum',
            'capture_notes' => 'Lorem ipsum dolor sit amet',
            'venues' => 'Lorem ipsum dolor sit amet',
            'pre_production_date' => '2025-02-16',
            'production_date' => '2025-02-17',
            'post_production_date' => '2025-02-18',
            'has_attended_photography_discipline' => true,
            'has_attended_sound_discipline' => true,
            'has_attended_art_discipline' => true,
            'owner_id' => $owner->id,
            'production_category_id' => $productionCategory->id,
            'professor_id' => $professor->id,
            'directors' => [
                ['id' => $owner->id],
            ],
            'producers' => [
                ['id' => $owner->id],
            ],
            'photography_directors' => [
                ['id' => $owner->id],
            ],
            'sound_directors' => [
                ['id' => $owner->id],
            ],
            'art_directors' => [
                ['id' => $owner->id],
            ],
        ];
    }

    protected function getUpdatedData(array $updateData): array
    {
        return [
            ...Arr::except($updateData, [
                'directors',
                'producers',
                'photography_directors',
                'sound_directors',
                'art_directors'
            ]),
            'has_attended_photography_discipline' => 1,
            'has_attended_sound_discipline' => 1,
            'has_attended_art_discipline' => 1,
        ];
    }

    protected function additionalUpdateAssertions(): void
    {
        $this->assertDatabaseCount('project_user', 5);

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'director']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'producer']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'photography-director']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'sound-director']
        );

        $this->assertDatabaseHas(
            'project_user',
            ['role' => 'art-director']
        );
    }

    protected function getRemoveRoute(): string
    {
        $project = Project::factory()
            ->createOne();

        return "projetos/{$project->id}/remover";
    }

    protected function additionalRemoveAssertions(): void
    {
        $this->assertDatabaseCount('project_user', 0);
    }

    protected function getTableName(): string
    {
        return 'projects';
    }

    protected function getVersionsTableName(): string
    {
        return 'projects_versions';
    }
}
