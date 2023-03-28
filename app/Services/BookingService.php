<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookingVersionEvent;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BookingService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::get as baseGet;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Booking::class;

    protected string $modelVersionEventClass = BookingVersionEvent::class;

    protected string $modelVersionTableName = 'bookings_versions';

    protected string $modelVersionIdColumnName = 'booking_id';

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @param  array{start_date:string,end_date:string}  $data
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
     * @param  string[]  $relations
     */
    public function get(
        int $id,
        array $relations = ['owner', 'project', 'bookables']
    ): Booking {
        /** @var Booking $booking */
        $booking = $this->baseGet($id, $relations);

        return $booking;
    }

    /**
     * @param  Builder<Booking>  $query
     * @return Builder<Booking>
     */
    protected function beforePagination(
        Builder $query,
        Request $request
    ): Builder {
        if (is_string($request->input('status'))) {
            switch ($request->input('status')) {
                case 'owned_only':
                    $query->where(
                        'owner_id',
                        '=',
                        $this->authService->getAuthIdOrFail()
                    );
                    break;
            }
        }

        return $query;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterCreated(Booking $booking, array $data): Booking
    {
        /** @var array<int,array<string,mixed>> */
        $bookables = $data['bookables'];

        $booking->bookables()->attach(array_column($bookables, 'id'));

        return $booking;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterUpdated(Booking $booking, array $data): void
    {
        /** @var array<int,array<string,mixed>> */
        $bookables = $data['bookables'];

        $booking->bookables()->sync(array_column($bookables, 'id'));
    }
}
