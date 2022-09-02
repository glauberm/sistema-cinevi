<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RemoveRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait CrudControllerTrait
{
    protected string $createdMessage = 'O item foi criado com sucesso.';

    protected string $updatedMessage = 'O item foi editado com sucesso.';

    protected string $removedMessage = 'O item foi removido com sucesso.';

    /**
     * @param  Request             $request
     * @return ResourceCollection
     */
    public function paginate(Request $request): ResourceCollection
    {
        return $this->resourceClass::collection($this->service->paginate($request->all()));
    }

    /**
     * @param  FormRequest   $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $model = $this->service->create($data);

        return response()->json(
            [
                'message' => $this->createdMessage,
                'resource' => new $this->resourceClass($model),
            ],
            201,
        );
    }

    /**
     * @param  Request       $request
     * @param  integer       $id
     * @return JsonResource
     */
    public function show(Request $request, int $id): JsonResource
    {
        /** @var JsonResource $resource */
        $resource = new $this->resourceClass($this->service->get($id));

        return $resource;
    }

    /**
     * @param  FormRequest   $request
     * @param  integer       $id
     * @return JsonResponse
     */
    public function update(FormRequest $request, int $id): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->service->update($data, $id);

        return response()->json(['message' => $this->updatedMessage]);
    }

    /**
     * @param  RemoveRequest  $request
     * @param  integer        $id
     * @return JsonResponse
     */
    public function remove(RemoveRequest $request, int $id): JsonResponse
    {
        $this->service->remove($id);

        return response()->json(['message' => $this->removedMessage]);
    }
}
