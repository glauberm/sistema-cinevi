<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Bookable;
use App\Models\Booking;
use App\Models\Configuration;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

class BookingCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'reservas';
    }

    protected function getCreateRoute(): string
    {
        return 'reservas/adicionar';
    }

    protected function getCreateData(): array
    {
        Configuration::factory()
            ->createOne();

        $owner = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $project = Project::factory()
            ->createOne();

        $bookable = Bookable::factory()
            ->createOne();

        return [
            'withdrawal_date' => '2025-02-17',
            'devolution_date' => '2025-02-20',
            'owner_id' => $owner->id,
            'project_id' => $project->id,
            'bookables' => [
                ['id' => $bookable->id]
            ]
        ];
    }

    protected function getCreatedData(array $createData): array
    {
        return Arr::except($createData, ['bookables']);
    }

    protected function additionalCreateAssertions(): void
    {
        $this->assertDatabaseCount('bookable_booking', 1);
    }

    protected function getUpdateRoute(): string
    {
        $booking = Booking::factory()
            ->createOne();

        return "reservas/{$booking->id}/editar";
    }

    protected function getUpdateData(): array
    {
        Configuration::factory()
            ->createOne();

        $owner = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->createOne();

        $project = Project::factory()
            ->createOne();

        $bookable = Bookable::factory()
            ->createOne();

        return [
            'withdrawal_date' => '2025-02-17',
            'devolution_date' => '2025-02-20',
            'owner_id' => $owner->id,
            'project_id' => $project->id,
            'bookables' => [
                ['id' => $bookable->id]
            ]
        ];
    }

    protected function getUpdatedData(array $updateData): array
    {
        return Arr::except($updateData, ['bookables']);
    }

    protected function additionalUpdateAssertions(): void
    {
        $this->assertDatabaseCount('bookable_booking', 1);
    }

    protected function getRemoveRoute(): string
    {
        $booking = Booking::factory()
            ->createOne();

        return "reservas/{$booking->id}/remover";
    }

    protected function getTableName(): string
    {
        return 'bookings';
    }

    protected function getVersionsTableName(): string
    {
        return 'bookings_versions';
    }
}
