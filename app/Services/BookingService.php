<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookingVersionEvent;
use App\Models\Booking;

class BookingService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Booking::class;

    protected string $modelVersionEventClass = BookingVersionEvent::class;

    protected string $modelVersionTableName = 'bookings_versions';

    protected string $modelVersionIdColumnName = 'booking_id';
}
