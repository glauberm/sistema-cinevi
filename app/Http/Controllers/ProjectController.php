<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ProjectCreateOrUpdateRequest;
use App\Http\Resources\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProjectController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Project::class;

    protected ProjectService $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * @param  ProjectCreateOrUpdateRequest  $request
     * @return JsonResponse
     */
    public function doCreate(ProjectCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  ProjectCreateOrUpdateRequest  $request
     * @param  integer                       $id
     * @return JsonResponse
     */
    public function doUpdate(ProjectCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
