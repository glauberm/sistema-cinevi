<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Bookable;
use App\Models\Booking;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    protected string $modelClass = Booking::class;

    protected string $baseApiUrl = 'api/reservas';

    protected string $tableName = 'bookings';

    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        $owner = User::factory()->createOne();

        $project = Project::factory()->createOne();

        $bookables = Bookable::factory()->count(3)->create();

        return [
            'withdrawal_date' => '2022-10-21',
            'devolution_date' => '2022-10-27',
            'owner' => $owner->toArray(),
            'project' => $project->toArray(),
            'bookables' => $bookables->toArray()
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getCreateDatabaseFields(): array
    {
        return [
            'withdrawal_date' => '2022-10-21',
            'devolution_date' => '2022-10-27',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        $owner = User::factory()->createOne();

        $project = Project::factory()->createOne();

        $bookables = Bookable::factory()->count(3)->create();

        return [
            'withdrawal_date' => '2022-11-21',
            'devolution_date' => '2022-11-25',
            'owner' => $owner->toArray(),
            'project' => $project->toArray(),
            'bookables' => $bookables->toArray()
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'withdrawal_date' => '2022-11-21',
            'devolution_date' => '2022-11-25',
        ];
    }
}
