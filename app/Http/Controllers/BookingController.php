<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\BookingCreateOrUpdateRequest;
use App\Http\Requests\BookingShowBetweenRequest;
use App\Http\Resources\Booking;
use App\Mail\BookingCreatedOrUpdatedMail;
use App\Models\Booking as BookingModel;
use App\Services\BookingService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Booking::class;

    protected BookingService $service;

    protected UserService $userService;

    public function __construct(BookingService $service, UserService $userService)
    {
        $this->service = $service;

        $this->userService = $userService;

        $this->middleware(Authenticate::class.':sanctum');
    }

    public function showBetween(BookingShowBetweenRequest $request): ResourceCollection
    {
        /** @var array{start_date:string,end_date:string} */
        $data = $request->validated();

        return $this->resourceClass::collection($this->service->showBetween($data));
    }

    /**
     * @param  BookingCreateOrUpdateRequest  $request
     * @return JsonResponse
     */
    public function doCreate(BookingCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  BookingCreateOrUpdateRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function doUpdate(BookingCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }

    /**
     * @param  BookingCreateOrUpdateRequest  $request
     * @param  BookingModel  $booking
     * @return void
     */
    protected function afterCreated(BookingCreateOrUpdateRequest $request, BookingModel $booking): void
    {
        $warehouseUsers = $this->userService->getAllWithRole('warehouse');

        foreach ($warehouseUsers as $user) {
            Mail::to($user->email)->queue(new BookingCreatedOrUpdatedMail($booking, 'created'));
        }

        Mail::to($booking->project->professor->email)
            ->queue(new BookingCreatedOrUpdatedMail($booking, 'created-professor'));
    }

    /**
     * @param  BookingCreateOrUpdateRequest  $request
     * @param  int  $id
     * @return void
     */
    protected function afterUpdated(BookingCreateOrUpdateRequest $request, int $id): void
    {
        $booking = $this->service->get($id);

        $warehouseUsers = $this->userService->getAllWithRole('warehouse');

        foreach ($warehouseUsers as $user) {
            Mail::to($user->email)->queue(new BookingCreatedOrUpdatedMail($booking, 'updated'));
        }

        Mail::to($booking->project->professor->email)
            ->queue(new BookingCreatedOrUpdatedMail($booking, 'updated-professor'));
    }
}
