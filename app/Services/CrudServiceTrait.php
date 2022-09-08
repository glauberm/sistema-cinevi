<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait CrudServiceTrait
{
    /**
     * @param  Request  $request
     * @return LengthAwarePaginator
     */
    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = $this->modelClass::orderBy(
            $request->input('order_by_column', 'id'),
            $request->input('order_by_direction', 'desc')
        );

        $query = $this->beforePagination($query, $request);

        $itemsPerPage = $request->input('items_per_page', 10);

        if (! \is_int($itemsPerPage)) {
            throw new \InvalidArgumentException('O número de itens por página deve ser um inteiro.');
        }

        return $query->paginate($itemsPerPage, ['*'], 'page');
    }

    /**
     * @param  array<string,mixed>  $data
     * @param  string|null  $eventAction
     * @param  string|null  $eventMessage
     * @return Model
     */
    public function create(array $data, ?string $eventAction = 'create', ?string $eventMessage = 'O item foi criado.'): Model
    {
        $model = $this->modelClass::create($data);

        $model = $this->afterCreated($model, $data);

        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass($model, $eventAction, $eventMessage));
        }

        return $model;
    }

    /**
     * @param  int  $id
     * @return Model
     *
     * @throws ModelNotFoundException
     */
    public function get(int $id): Model
    {
        return $this->modelClass::findOrFail($id);
    }

    /**
     * @param  array<string,mixed>  $data
     * @param  int  $id
     * @param  string|null  $eventAction
     * @param  string|null  $eventMessage
     * @return void
     */
    public function update(array $data, int $id, ?string $eventAction = 'update', ?string $eventMessage = 'O item foi editado.'): void
    {
        $model = $this->get($id);

        $model->update($data);

        /** @phpstan-ignore-next-line */
        $this->afterUpdated($model, $data);

        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass($model, $eventAction, $eventMessage));
        }
    }

    /**
     * @param  int  $id
     * @param  string|null  $eventAction
     * @param  string|null  $eventMessage
     * @return void
     */
    public function remove(int $id, ?string $eventAction = 'remove', ?string $eventMessage = 'O item foi removido.'): void
    {
        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass($this->get($id), $eventAction, $eventMessage));
        }

        $this->modelClass::destroy($id);
    }

    /**
     * @param  Builder<Model>  $query
     * @param  Request  $request
     * @return Builder<Model>
     */
    protected function beforePagination(Builder $query, Request $request): Builder
    {
        return $query;
    }

    /**
     * @param  Model  $model
     * @param  array<string,mixed>  $data
     * @return Model
     */
    protected function afterCreated(Model $model, array $data): Model
    {
        return $model;
    }

    /**
     * @param  Model  $model
     * @param  array<string,mixed>  $data
     * @return Model
     */
    protected function afterUpdated(Model $model, array $data): Model
    {
        return $model;
    }
}
