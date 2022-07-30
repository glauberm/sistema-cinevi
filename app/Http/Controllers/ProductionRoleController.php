<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProductionRoleCreateOrUpdateRequest;
use App\Http\Resources\ProductionRole;
use App\Services\CrudServiceInterface;
use App\Services\HasVersionsServiceInterface;
use App\Services\ProductionRoleService;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductionRoleController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = ProductionRole::class;

    protected CrudServiceInterface&HasVersionsServiceInterface $service;

    public function __construct(ProductionRoleService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * Passa a requisição do formulário de criação para a interface CRUD.
     *
     * @param  ProductionRoleCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function doCreate(ProductionRoleCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * Passa a requisição do formulário de edição para a interface CRUD.
     *
     * @param  ProductionRoleCreateOrUpdateRequest $request
     * @param  integer                             $id
     * @return JsonResponse
     */
    public function doUpdate(ProductionRoleCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
