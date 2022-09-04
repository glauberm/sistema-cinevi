<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\FinalCopyCreateOrUpdateRequest;
use App\Http\Resources\FinalCopy;
use App\Services\FinalCopyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class FinalCopyController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = FinalCopy::class;

    protected FinalCopyService $service;

    public function __construct(FinalCopyService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * @param  FinalCopyCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function doCreate(FinalCopyCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  FinalCopyCreateOrUpdateRequest  $request
     * @param  integer                         $id
     * @return JsonResponse
     */
    public function doUpdate(FinalCopyCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
