<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookableVersionEvent;
use App\Models\Bookable;

class BookableService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Bookable::class;

    protected string $modelVersionEventClass = BookableVersionEvent::class;

    protected string $modelVersionTableName = 'bookables_versions';

    protected string $modelVersionIdColumnName = 'bookable_id';

    /**
     * @param  int  $id
     * @return Bookable
     */
    public function get(int $id): Bookable
    {
        return $this->modelClass::with(['bookableCategory', 'users', 'bookings'])->findOrFail($id);
    }

    /**
     * @param  Bookable  $bookable
     * @param  array<string,mixed>  $data
     * @return Bookable
     */
    public function afterCreated(Bookable $bookable, array $data): Bookable
    {
        if (\array_key_exists('users', $data) && \is_array($data['users'])) {
            /** @var array<int,array<string,mixed>> */
            $users = $data['users'];

            $bookable->users()->attach(\array_column($users, 'id'));
        }

        return $bookable;
    }

    /**
     * @param  Bookable  $bookable
     * @param  array<string,mixed>  $data
     * @return void
     */
    public function afterUpdated(Bookable $bookable, array $data): void
    {
        if (\array_key_exists('users', $data) && \is_array($data['users'])) {
            /** @var array<int,array<string,mixed>> */
            $users = $data['users'];

            $bookable->users()->sync(\array_column($users, 'id'));
        }
    }
}
