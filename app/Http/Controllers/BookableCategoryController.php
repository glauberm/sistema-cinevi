<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\BookableCategoryCreateOrUpdateRequest;
use App\Http\Requests\BookableCategoryRemoveRequest;
use App\Http\Resources\BookableCategory;
use App\Services\BookableCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BookableCategoryController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = BookableCategory::class;

    public function __construct(protected readonly BookableCategoryService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function create(BookableCategoryCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->doCreate($request);
    }

    public function update(BookableCategoryCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(BookableCategoryRemoveRequest $request, int $id): JsonResponse
    {
        return $this->doRemove($request, $id);
    }
}
