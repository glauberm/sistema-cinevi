<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateOrUpdateRequest;
use App\Http\Resources\Booking;
use App\Services\BookingService;
use App\Services\CrudServiceInterface;
use App\Services\HasVersionsServiceInterface;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BookingController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Booking::class;

    protected CrudServiceInterface&HasVersionsServiceInterface $service;

    public function __construct(BookingService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
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
