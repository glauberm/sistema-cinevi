<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

trait CrudControllerTrait
{
    protected string $createdMessage = 'O item foi criado com sucesso.';
    protected string $updatedMessage = 'O item foi editado com sucesso.';
    protected string $removedMessage = 'O item foi removido com sucesso.';

    /**
     * Mostra uma coleção de recursos.
     *
     * @param  Request            $request
     * @return ResourceCollection
     */
    public function paginate(Request $request): ResourceCollection
    {
        return $this->resourceClass::collection($this->service->paginate($request->all()));
    }

    /**
     * Adiciona um recurso.
     *
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse
    {
        if (!\is_array($request->validated())) {
            throw new \TypeError('A requisição está em um formato inválido.');
        }

        $model = $this->service->create($request->validated());

        return response()->json(
            [
                'message' => $this->createdMessage,
                'resource' => new $this->resourceClass($model),
            ],
            201,
        );
    }

    /**
     * Mostra um recurso.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResource
     */
    public function show(Request $request, int $id): JsonResource
    {
        /** @var JsonResource $resource */
        $resource = new $this->resourceClass($this->service->get($id));

        return $resource;
    }

    /**
     * Atualiza um recurso.
     *
     * @param FormRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws ConflictHttpException
     */
    public function update(FormRequest $request, int $id): JsonResponse
    {
        if (!\is_array($request->validated())) {
            throw new \TypeError('A requisição está em um formato inválido.');
        }

        $this->service->update($request->validated(), $id);

        return response()->json(['message' => $this->updatedMessage]);
    }

    /**
     * Remove um recurso.
     *
     * @param int $id
     * @return JsonResponse
     * @throws AccessDeniedHttpException
     */
    public function remove(int $id): JsonResponse
    {
        if (Gate::allows('isAdmin') === true) {
            $this->service->remove($id);

            return response()->json(['message' => $this->removedMessage]);
        }

        throw new AccessDeniedHttpException('Você não tem permissão para remover itens permanentemente.');
    }
}
