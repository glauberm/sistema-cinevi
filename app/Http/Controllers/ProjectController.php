<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProjectCreateOrUpdateRequest;
use App\Http\Requests\ProjectRemoveRequest;
use App\Http\Resources\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProjectController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Project::class;

    public function __construct(protected readonly ProjectService $service)
    {
        $this->middleware(Authenticate::class.':sanctum');
    }

    public function create(ProjectCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->doCreate($request);
    }

    public function update(ProjectCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(ProjectRemoveRequest $request, int $id): JsonResponse
    {
        return $this->doRemove($request, $id);
    }
}
