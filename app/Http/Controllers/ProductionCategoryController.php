<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProductionCategoryCreateOrUpdateRequest;
use App\Http\Requests\ProductionCategoryRemoveRequest;
use App\Services\ProductionCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ProductionCategoryController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $paginateRoute = 'production-category.index';

    protected string $paginateView = 'pages/production-category/index';

    protected string $paginateVersionsView = 'pages/production-category/versions-index';

    protected string $showVersionView = 'pages/production-category/version';

    public function __construct(protected readonly ProductionCategoryService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function create(ProductionCategoryCreateOrUpdateRequest $request): RedirectResponse
    {
        return $this->doCreate($request);
    }

    public function update(ProductionCategoryCreateOrUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(ProductionCategoryRemoveRequest $request, int $id): RedirectResponse
    {
        return $this->doRemove($request, $id);
    }
}
