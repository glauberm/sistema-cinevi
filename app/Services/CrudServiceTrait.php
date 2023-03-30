<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

trait CrudServiceTrait
{
    /**
     * @return LengthAwarePaginator<Model>
     */
    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = $this->modelClass::orderBy(
            $request->input('ordenar_pela_coluna', 'id'),
            $request->input('ordenar_pela_direcao', 'desc')
        );

        $query = $this->beforePagination($query, $request);

        $itemsPerPage = $request->input('itens_por_pagina', 10);

        if (!is_int($itemsPerPage)) {
            throw new InvalidArgumentException(
                'O número de itens por página deve ser um número inteiro.'
            );
        }

        /** @phpstan-ignore-next-line */
        return $query->paginate($itemsPerPage, ['*'], 'pagina');
    }

    /**
     * @param  array<string,mixed>  $data
     */
    public function create(array $data, ?string $eventAction = 'create', ?string $eventMessage = 'O item foi criado.'): Model
    {
        $model = $this->modelClass::create($data);

        $model = $this->afterCreated($model, $data);

        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass(
                $model,
                $eventAction,
                $eventMessage
            ));
        }

        return $model;
    }

    /**
     * @param  string[]  $relations
     */
    public function get(int $id, array $relations = []): Model
    {
        return $this->modelClass::with($relations)->findOrFail($id);
    }

    /**
     * @param  array<string,mixed>  $data
     */
    public function update(array $data, int $id, ?string $eventAction = 'update', ?string $eventMessage = 'O item foi editado.'): void
    {
        $model = $this->get($id);

        $model->update($data);

        /** @phpstan-ignore-next-line */
        $this->afterUpdated($model, $data);

        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass(
                $model,
                $eventAction,
                $eventMessage
            ));
        }
    }

    public function remove(int $id, ?string $eventAction = 'remove', ?string $eventMessage = 'O item foi removido.'): void
    {
        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass(
                $this->get($id),
                $eventAction,
                $eventMessage
            ));
        }

        $this->modelClass::destroy($id);
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    protected function beforePagination(Builder $query, Request $request): Builder
    {
        return $query;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterCreated(Model $model, array $data): Model
    {
        return $model;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterUpdated(Model $model, array $data): Model
    {
        return $model;
    }
}
