<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Bookable;
use App\Models\FinalCopy;
use App\Models\Configuration;
use App\Models\ProductionCategory;
use App\Models\ProductionRole;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class FinalCopyCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'copias-finais';
    }

    protected function getCreateRoute(): string
    {
        return 'copias-finais/adicionar';
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

        $productionRole = ProductionRole::factory()
            ->createOne();

        return [
            'title' => 'Lorem Ipsum',
            'synopsis' => 'Lorem Ipsum Dolor Sit Amet',
            'genres' => 'Lorem, Ipsum',
            'capture_format' => 'Lorem',
            'capture_notes' => 'Lorem Ipsum Dolor Sit Amet',
            'venues' => 'Lorem Ipsum, Dolor Sit Amet',
            'video_url' => 'http://example.com/',
            'video_password' => 'L0r3M',
            'chromia' => 'Lorem',
            'proportion' => 'Ipsum',
            'format' => 'Dolor',
            'duration' => 'Sit',
            'native_digital_format' => 'Amet',
            'codec' => 'Lorem',
            'container' => 'Ipsum',
            'bitrate' => 'Dolor',
            'fps' => 'Sit',
            'sound' => 'Amet',
            'digital_sound_resolution' => 'Lorem',
            'digital_matrix_support' => 'Ipsum',
            'camera' => 'Dolor Sit Amet',
            'editing_software' => 'Lorem Ipsum',
            'sound_capture_equipment' => 'Lorem',
            'budget' => '3000',
            'financing_sources' => 'Lorem Ipsum',
            'supporters' => 'Lorem Ipsum Dolor Sit Amet',
            'has_dcp' => true,
            'cast' => 'Lorem Ipsum Dolor Sit Amet',
            'participations' => 'Lorem Ipsum Dolor Sit Amet',
            'prizes' => 'Lorem Ipsum Dolor Sit Amet',
            'confirmed' => true,
            'owner_id' => $owner->id,
            'production_category_id' => $productionCategory->id,
            'professor_id' => $professor->id,
            'production_roles' => [
                [
                    'production_role_id' => $productionRole->id,
                    'users' => [
                        ['id' => $owner->id]
                    ]
                ]
            ]
        ];
    }

    protected function getCreatedData(array $createData): array
    {
        return [
            ...Arr::except($createData, ['production_roles']),
            'has_dcp' => 1,
            'confirmed' => 1,
        ];
    }

    protected function additionalCreateAssertions(): void
    {
        $this->assertDatabaseCount('final_copy_production_role', 1);

        $this->assertDatabaseCount('final_copies_production_roles_users', 1);
    }

    protected function getUpdateRoute(): string
    {
        $finalCopy = FinalCopy::factory()
            ->createOne();

        return "copias-finais/{$finalCopy->id}/editar";
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

        $productionRole = ProductionRole::factory()
            ->createOne();

        return [
            'title' => 'Lorem Ipsum',
            'synopsis' => 'Lorem Ipsum Dolor Sit Amet',
            'genres' => 'Lorem, Ipsum',
            'capture_format' => 'Lorem',
            'capture_notes' => 'Lorem Ipsum Dolor Sit Amet',
            'venues' => 'Lorem Ipsum, Dolor Sit Amet',
            'video_url' => 'http://example.com/',
            'video_password' => 'L0r3M',
            'chromia' => 'Lorem',
            'proportion' => 'Ipsum',
            'format' => 'Dolor',
            'duration' => 'Sit',
            'native_digital_format' => 'Amet',
            'codec' => 'Lorem',
            'container' => 'Ipsum',
            'bitrate' => 'Dolor',
            'fps' => 'Sit',
            'sound' => 'Amet',
            'digital_sound_resolution' => 'Lorem',
            'digital_matrix_support' => 'Ipsum',
            'camera' => 'Dolor Sit Amet',
            'editing_software' => 'Lorem Ipsum',
            'sound_capture_equipment' => 'Lorem',
            'budget' => '3000',
            'financing_sources' => 'Lorem Ipsum',
            'supporters' => 'Lorem Ipsum Dolor Sit Amet',
            'has_dcp' => true,
            'cast' => 'Lorem Ipsum Dolor Sit Amet',
            'participations' => 'Lorem Ipsum Dolor Sit Amet',
            'prizes' => 'Lorem Ipsum Dolor Sit Amet',
            'confirmed' => true,
            'owner_id' => $owner->id,
            'production_category_id' => $productionCategory->id,
            'professor_id' => $professor->id,
            'production_roles' => [
                [
                    'production_role_id' => $productionRole->id,
                    'users' => [
                        ['id' => $owner->id]
                    ]
                ]
            ]
        ];
    }

    protected function getUpdatedData(array $updateData): array
    {
        return [
            ...Arr::except($updateData, ['production_roles']),
            'has_dcp' => 1,
            'confirmed' => 1,
        ];
    }

    protected function additionalUpdateAssertions(): void
    {
        $this->assertDatabaseCount('final_copy_production_role', 1);

        $this->assertDatabaseCount('final_copies_production_roles_users', 1);
    }

    protected function getRemoveRoute(): string
    {
        $finalCopy = FinalCopy::factory()
            ->createOne();

        return "copias-finais/{$finalCopy->id}/remover";
    }

    protected function getTableName(): string
    {
        return 'final_copies';
    }

    protected function getVersionsTableName(): string
    {
        return 'final_copies_versions';
    }
}
