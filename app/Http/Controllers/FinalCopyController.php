<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\FinalCopyCreateOrUpdateRequest;
use App\Http\Requests\FinalCopyRemoveRequest;
use App\Http\Resources\FinalCopy;
use App\Services\FinalCopyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class FinalCopyController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = FinalCopy::class;

    public function __construct(protected readonly FinalCopyService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function create(FinalCopyCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->doCreate($request);
    }

    public function update(FinalCopyCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(FinalCopyRemoveRequest $request, int $id): JsonResponse
    {
        return $this->doRemove($request, $id);
    }
}
