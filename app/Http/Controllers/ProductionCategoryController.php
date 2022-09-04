<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProductionCategoryCreateOrUpdateRequest;
use App\Http\Resources\ProductionCategory;
use App\Services\ProductionCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductionCategoryController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = ProductionCategory::class;

    protected ProductionCategoryService $service;

    public function __construct(ProductionCategoryService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * @param  ProductionCategoryCreateOrUpdateRequest  $request
     * @return JsonResponse
     */
    public function doCreate(ProductionCategoryCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  ProductionCategoryCreateOrUpdateRequest  $request
     * @param  integer                                  $id
     * @return JsonResponse
     */
    public function doUpdate(ProductionCategoryCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
