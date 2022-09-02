<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookingVersionEvent;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @param  Booking              $booking
     * @param  array<string,mixed>  $data
     * @return Booking
     */
    public function afterCreated(Booking $booking, array $data): Booking
    {
        /** @var array<int,array<string,mixed>> */
        $bookables = $data['bookables'];

        $booking->bookables()->attach(\array_column($bookables, 'id'));

        return $booking;
    }

    /**
     * @param  Booking              $booking
     * @param  array<string,mixed>  $data
     * @return void
     */
    public function afterUpdated(Booking $booking, array $data): void
    {
        /** @var array<int,array<string,mixed>> */
        $bookables = $data['bookables'];

        $booking->bookables()->sync(\array_column($bookables, 'id'));
    }
}
