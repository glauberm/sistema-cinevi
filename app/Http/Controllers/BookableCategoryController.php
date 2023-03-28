<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\BookableCategoryCreateOrUpdateRequest;
use App\Http\Requests\BookableCategoryRemoveRequest;
use App\Services\BookableCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class BookableCategoryController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $paginateRoute = 'bookable_category.index';

    protected string $paginateView = 'pages/bookable_category/index';

    protected string $paginateVersionsView;

    protected string $showVersionView;

    public function __construct(
        protected readonly BookableCategoryService $service
    ) {
        $this->middleware(Authenticate::class);
    }

    public function create(
        BookableCategoryCreateOrUpdateRequest $request
    ): RedirectResponse {
        return $this->doCreate($request);
    }

    public function update(
        BookableCategoryCreateOrUpdateRequest $request,
        int $id
    ): RedirectResponse {
        return $this->doUpdate($request, $id);
    }

    public function remove(
        BookableCategoryRemoveRequest $request,
        int $id
    ): RedirectResponse {
        return $this->doRemove($request, $id);
    }
}
