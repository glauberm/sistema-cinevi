<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookingVersionEvent;
use App\Models\Booking;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;

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
     * @param  array<string,mixed>  $data
     * @return Collection<int,Booking>
     */
    public function showBetween(array $data): Collection
    {
        $startDate = $data['start_date'];

        $endDate = $data['end_date'];

        return $this->modelClass::with(['owner'])
            ->whereBetween('withdrawal_date', [$startDate, $endDate])
            ->orWhereBetween('devolution_date', [$startDate, $endDate])
            ->get();
    }

    /**
     * @param  integer                 $id
     * @return Booking
     */
    public function get(int $id): Booking
    {
        return $this->modelClass::with(['owner', 'project', 'bookables'])->findOrFail($id);
    }

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
