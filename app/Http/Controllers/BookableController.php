<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BookableCreateOrUpdateRequest;
use App\Http\Resources\Bookable;
use App\Services\BookableService;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BookableController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Bookable::class;

    protected BookableService $service;

    public function __construct(BookableService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * @param  BookableCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function doCreate(BookableCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  BookableCreateOrUpdateRequest  $request
     * @param  integer                        $id
     * @return JsonResponse
     */
    public function doUpdate(BookableCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
