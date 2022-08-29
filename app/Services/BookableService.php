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
}
