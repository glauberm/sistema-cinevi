<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\UserCreateOrUpdateRequest;
use App\Http\Requests\UserRemoveRequest;
use App\Http\Resources\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class UserController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = User::class;

    protected UserService $service;

    public function __construct(UserService $service)
    {
        $this->middleware(Authenticate::class . ':sanctum');
        $this->service = $service;
    }

    /**
     * @param  UserCreateOrUpdateRequest  $request
     * @return JsonResponse
     */
    public function doCreate(UserCreateOrUpdateRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * @param  UserCreateOrUpdateRequest  $request
     * @param  integer                    $id
     * @return JsonResponse
     */
    public function doUpdate(UserCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }

    /**
     * @param  UserRemoveRequest  $request
     * @param  integer            $id
     * @return JsonResponse
     */
    public function doRemove(UserRemoveRequest $request, int $id): JsonResponse
    {
        return $this->remove($request, $id);
    }
}
