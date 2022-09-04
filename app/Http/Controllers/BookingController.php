<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateOrUpdateRequest;
use App\Http\Requests\BookingShowBetweenRequest;
use App\Http\Resources\Booking;
use App\Services\BookingService;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller;

class BookingController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Booking::class;

    protected BookingService $service;

    public function __construct(BookingService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    public function showBetween(BookingShowBetweenRequest $request): ResourceCollection
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        return $this->resourceClass::collection($this->service->showBetween($data));
    }

    /**
     * @param  BookingCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function doCreate(BookingCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  BookingCreateOrUpdateRequest  $request
     * @param  integer                       $id
     * @return JsonResponse
     */
    public function doUpdate(BookingCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
