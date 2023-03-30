<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\BookingCreateOrUpdateRequest;
use App\Http\Requests\BookingRemoveRequest;
use App\Http\Requests\BookingShowBetweenRequest;
use App\Http\Resources\Booking;
use App\Mail\BookingCreatedProfessorMail;
use App\Mail\BookingCreatedWarehouseMail;
use App\Mail\BookingUpdatedProfessorMail;
use App\Mail\BookingUpdatedWarehouseMail;
use App\Models\Booking as BookingModel;
use App\Services\BookingService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $paginateRoute = 'booking.index';

    protected string $paginateView = 'pages/booking/index';

    protected string $paginateVersionsView = 'pages/booking/versions-index';

    protected string $showVersionView = 'pages/booking/version';

    public function __construct(
        protected readonly BookingService $service,
        protected readonly UserService $userService
    ) {
        $this->middleware(Authenticate::class);
    }

    public function showBetween(BookingShowBetweenRequest $request): ResourceCollection
    {
        /** @var array{start_date:string,end_date:string} */
        $data = $request->validated();

        return Booking::collection($this->service->showBetween($data));
    }

    public function create(BookingCreateOrUpdateRequest $request): RedirectResponse
    {
        return $this->doCreate($request);
    }

    public function update(BookingCreateOrUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(BookingRemoveRequest $request, int $id): RedirectResponse
    {
        return $this->doRemove($request, $id);
    }

    protected function afterCreated(BookingCreateOrUpdateRequest $request, BookingModel $booking): void
    {
        $warehouseUsers = $this->userService
            ->getAllWithRole(UserRole::Warehouse);

        foreach ($warehouseUsers as $user) {
            Mail::to($user->email)
                ->queue(new BookingCreatedWarehouseMail($booking));
        }

        Mail::to($booking->project->professor->email)
            ->queue(new BookingCreatedProfessorMail($booking));
    }

    protected function afterUpdated(BookingCreateOrUpdateRequest $request, int $id): void
    {
        $booking = $this->service->get($id, ['project']);

        $warehouseUsers = $this->userService
            ->getAllWithRole(UserRole::Warehouse);

        foreach ($warehouseUsers as $user) {
            Mail::to($user->email)
                ->queue(new BookingUpdatedWarehouseMail($booking));
        }

        Mail::to($booking->project->professor->email)
            ->queue(new BookingUpdatedProfessorMail($booking));
    }
}