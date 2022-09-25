<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProductionRoleCreateOrUpdateRequest;
use App\Http\Requests\ProductionRoleRemoveRequest;
use App\Http\Resources\ProductionRole;
use App\Services\ProductionRoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductionRoleController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = ProductionRole::class;

    public function __construct(protected readonly ProductionRoleService $service)
    {
        $this->middleware(Authenticate::class.':sanctum');
    }

    public function create(ProductionRoleCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->doCreate($request);
    }

    public function update(ProductionRoleCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(ProductionRoleRemoveRequest $request, int $id): JsonResponse
    {
        return $this->doRemove($request, $id);
    }
}
