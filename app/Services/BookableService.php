<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookableVersionEvent;
use App\Models\Bookable;

class BookableService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::get as baseGet;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Bookable::class;

    protected string $modelVersionEventClass = BookableVersionEvent::class;

    protected string $modelVersionTableName = 'bookables_versions';

    protected string $modelVersionIdColumnName = 'bookable_id';

    public function hasConflictingBookingDate(int $id, string $withdrawalDate, string $devolutionDate): bool
    {
        $bookable = $this->modelClass::with(['bookings'])->findOrFail($id);

        foreach ($bookable->bookings as $booking) {
            if (($withdrawalDate >= $booking->withdrawal_date
                    && $withdrawalDate <= $booking->devolution_date) ||
                ($devolutionDate >= $booking->devolution_date
                    && $devolutionDate <= $booking->withdrawal_date) ||
                ($booking->withdrawal_date >= $withdrawalDate
                    && $booking->devolution_date <= $withdrawalDate) ||
                ($booking->devolution_date >= $devolutionDate
                    && $booking->withdrawal_date <= $devolutionDate)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  string[]  $relations
     */
    public function get(int $id, array $relations = [
        'bookableCategory',
        'users',
        'bookings'
    ]): Bookable
    {
        /** @var Bookable $bookable */
        $bookable = $this->baseGet($id, $relations);

        return $bookable;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterCreated(Bookable $bookable, array $data): Bookable
    {
        if (array_key_exists('users', $data) && is_array($data['users'])) {
            /** @var array<int,array<string,mixed>> */
            $users = $data['users'];

            $bookable->users()->attach(array_column($users, 'id'));
        }

        return $bookable;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterUpdated(Bookable $bookable, array $data): void
    {
        if (array_key_exists('users', $data) && is_array($data['users'])) {
            /** @var array<int,array<string,mixed>> */
            $users = $data['users'];

            $bookable->users()->sync(array_column($users, 'id'));
        }
    }
}
