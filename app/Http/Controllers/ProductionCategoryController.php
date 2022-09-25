<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProductionCategoryCreateOrUpdateRequest;
use App\Http\Requests\ProductionCategoryRemoveRequest;
use App\Http\Resources\ProductionCategory;
use App\Services\ProductionCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductionCategoryController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = ProductionCategory::class;

    public function __construct(protected readonly ProductionCategoryService $service)
    {
        $this->middleware(Authenticate::class.':sanctum');
    }

    public function create(ProductionCategoryCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->doCreate($request);
    }

    public function update(ProductionCategoryCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(ProductionCategoryRemoveRequest $request, int $id): JsonResponse
    {
        return $this->doRemove($request, $id);
    }
}
