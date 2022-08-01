<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateOrUpdateRequest;
use App\Http\Resources\User;
use App\Services\CrudServiceInterface;
use App\Services\HasVersionsServiceInterface;
use App\Services\UserService;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = User::class;

    protected CrudServiceInterface&HasVersionsServiceInterface $service;

    public function __construct(UserService $service)
    {
        $this->middleware(Authenticate::class . ':sanctum');

        $this->service = $service;
    }

    /**
     * Passa a requisição do formulário de criação para a interface CRUD.
     *
     * @param  UserCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function doCreate(UserCreateOrUpdateRequest $request): JsonResponse
    {
        if (Gate::allows('isAdmin')) {
            return $this->create($request);
        }

        throw new AccessDeniedHttpException('Você não tem permissão para criar usuários.');
    }

    /**
     * Passa a requisição do formulário de edição para a interface CRUD.
     *
     * @param  UserCreateOrUpdateRequest $request
     * @param  integer                             $id
     * @return JsonResponse
     */
    public function doUpdate(UserCreateOrUpdateRequest $request, int $id): JsonResponse
    {
        if (Gate::allows('isAdmin')) {
            return $this->update($request, $id);
        }

        throw new AccessDeniedHttpException('Você não tem permissão para atualizar este usuário.');
    }

    /**
     * Passa a requisição do formulário de remoção para a interface CRUD.
     *
     * @param  integer      $id
     * @return JsonResponse
     */
    public function doRemove(int $id): JsonResponse
    {
        if (Gate::allows('isAdmin') && Gate::allows('isNotUser', $this->service->get($id))) {
            return $this->remove($id);
        }

        throw new AccessDeniedHttpException('Você não tem permissão para remover este usuário.');
    }
}
