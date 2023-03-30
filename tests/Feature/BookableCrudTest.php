<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Bookable;
use App\Models\BookableCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class BookableCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'reservaveis';
    }

    protected function getCreateRoute(): string
    {
        return 'reservaveis/adicionar';
    }

    protected function getCreateData(): array
    {
        $bookableCategory = BookableCategory::factory()
            ->createOne();

        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        return [
            'identifier' => '09-01',
            'name' => 'Lorem Ipsum',
            'inventory_number' => '12345',
            'serial_number' => '54321',
            'accessories' => 'Lorem Ipsum Dolor Sit Amet',
            'notes' => 'Lorem Ipsum Dolor Sit Amet',
            'is_under_maintenance' => false,
            'is_return_overdue' => false,
            'bookable_category_id' => $bookableCategory->id,
            'users' => [
                [
                    'id' => $user->id,
                ],
            ]
        ];
    }

    protected function getCreatedData(array $createData): array
    {
        return Arr::except($createData, ['users']);
    }

    protected function additionalCreateAssertions(): void
    {
        $this->assertDatabaseCount('bookable_user', 1);
    }

    protected function getUpdateRoute(): string
    {
        $bookable = Bookable::factory()
            ->createOne();

        return "reservaveis/{$bookable->id}/editar";
    }

    protected function getUpdateData(): array
    {
        $bookableCategory = BookableCategory::factory()
            ->createOne();

        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        return [
            'identifier' => '09-01',
            'name' => 'Lorem Ipsum',
            'inventory_number' => '12345',
            'serial_number' => '54321',
            'accessories' => 'Lorem Ipsum Dolor Sit Amet',
            'notes' => 'Lorem Ipsum Dolor Sit Amet',
            'is_under_maintenance' => false,
            'is_return_overdue' => false,
            'bookable_category_id' => $bookableCategory->id,
            'users' => [
                ['id' => $user->id],
            ]
        ];
    }

    protected function getUpdatedData(array $updateData): array
    {
        return Arr::except($updateData, ['users']);
    }

    protected function additionalUpdateAssertions(): void
    {
        $this->assertDatabaseCount('bookable_user', 1);
    }

    protected function getRemoveRoute(): string
    {
        $bookable = Bookable::factory()
            ->createOne();

        return "reservaveis/{$bookable->id}/remover";
    }

    protected function getTableName(): string
    {
        return 'bookables';
    }

    protected function getVersionsTableName(): string
    {
        return 'bookables_versions';
    }
}
