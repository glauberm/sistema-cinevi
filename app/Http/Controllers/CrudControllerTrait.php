<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RemoveRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait CrudControllerTrait
{
    protected string $createdMessage = 'O item foi criado com sucesso.';

    protected string $updatedMessage = 'O item foi editado com sucesso.';

    protected string $removedMessage = 'O item foi removido com sucesso.';

    /**
     * @param  Request  $request
     * @return ResourceCollection
     */
    public function paginate(Request $request): ResourceCollection
    {
        return $this->resourceClass::collection($this->service->paginate($request));
    }

    /**
     * @param  FormRequest  $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $model = $this->service->create($data);

        /** @phpstan-ignore-next-line */
        $this->afterCreated($request, $model);

        return response()->json(
            [
                'message' => $this->createdMessage,
                'resource' => new $this->resourceClass($model),
            ],
            201,
        );
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResource
     */
    public function show(Request $request, int $id): JsonResource
    {
        /** @var JsonResource $resource */
        $resource = new $this->resourceClass($this->service->get($id));

        return $resource;
    }

    /**
     * @param  FormRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(FormRequest $request, int $id): JsonResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->service->update($data, $id);

        /** @phpstan-ignore-next-line */
        $this->afterUpdated($request, $id);

        return response()->json(['message' => $this->updatedMessage]);
    }

    /**
     * @param  RemoveRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function remove(RemoveRequest $request, int $id): JsonResponse
    {
        $this->service->remove($id);

        return response()->json(['message' => $this->removedMessage]);
    }

    /**
     * @param  FormRequest  $request
     * @param  Model  $model
     * @return void
     */
    protected function afterCreated(FormRequest $request, Model $model): void
    {
        //
    }

    /**
     * @param  FormRequest  $request
     * @param  int  $id
     * @return void
     */
    protected function afterUpdated(FormRequest $request, int $id): void
    {
        //
    }
}
