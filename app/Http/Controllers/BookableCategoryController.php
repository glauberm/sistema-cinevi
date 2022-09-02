<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\BookableCategoryCreateOrUpdateRequest;
use App\Http\Resources\BookableCategory;
use App\Services\BookableCategoryService;
use App\Services\CrudServiceInterface;
use App\Services\HasVersionsServiceInterface;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BookableCategoryController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = BookableCategory::class;

    protected CrudServiceInterface&HasVersionsServiceInterface $service;

    public function __construct(BookableCategoryService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * @param  BookableCategoryCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function doCreate(BookableCategoryCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  BookableCategoryCreateOrUpdateRequest $request
     * @param  integer                               $id
     * @return JsonResponse
     */
    public function doUpdate(BookableCategoryCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
