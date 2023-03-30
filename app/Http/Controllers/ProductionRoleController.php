<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProductionRoleCreateOrUpdateRequest;
use App\Http\Requests\ProductionRoleRemoveRequest;
use App\Services\ProductionRoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ProductionRoleController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $paginateRoute = 'production-role.index';

    protected string $paginateView = 'pages/production-role/index';

    protected string $paginateVersionsView = 'pages/production-role/versions-index';

    protected string $showVersionView = 'pages/production-role/version';

    public function __construct(protected readonly ProductionRoleService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function create(ProductionRoleCreateOrUpdateRequest $request): RedirectResponse
    {
        return $this->doCreate($request);
    }

    public function update(ProductionRoleCreateOrUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(ProductionRoleRemoveRequest $request, int $id): RedirectResponse
    {
        return $this->doRemove($request, $id);
    }
}
