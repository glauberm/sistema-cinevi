<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

trait CrudServiceTrait
{
    protected string $orderByColumn = 'id';

    protected string $orderByDirection = 'desc';

    protected int $itemsPerPage = 10;

    /**
     * Ordena e pagina os itens.
     *
     * @param array<string, mixed>  $data
     * @return LengthAwarePaginator
     */
    public function paginate(array $data): LengthAwarePaginator
    {
        if (!\array_key_exists('orderByColumn', $data)) {
            $data['orderByColumn'] = $this->orderByColumn;
        }

        if (!\array_key_exists('orderByDirection', $data)) {
            $data['orderByDirection'] = $this->orderByDirection;
        }

        if (!\array_key_exists('itemsPerPage', $data)) {
            $data['itemsPerPage'] = $this->itemsPerPage;
        }

        if (!\is_int($data['itemsPerPage'])) {
            throw new \TypeError('O parâmetro "itemsPerPage" deve ser um inteiro.');
        }

        $query = $this->modelClass::orderBy($data['orderByColumn'], $data['orderByDirection']);

        $query = $this->beforePagination($query, $data);

        return $query->paginate($data['itemsPerPage'], ['*'], 'page');
    }

    /**
     * Adiciona um recurso.
     *
     * @param array<string, mixed> $data
     * @param string|null          $eventAction
     * @param string|null          $eventMessage
     * @return Model
     */
    public function create(
        array $data,
        ?string $eventAction = 'create',
        ?string $eventMessage = 'O item foi criado.'
    ): Model {
        $model = $this->modelClass::create($data);

        $model = $this->afterCreated($model, $data);

        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass($model, $eventAction, $eventMessage));
        }

        return $model;
    }

    /**
     * Retorna um recurso.
     *
     * @param int $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function get(int $id): Model
    {
        return $this->modelClass::findOrFail($id);
    }

    /**
     * Atualiza um recurso.
     *
     * @param array<string, mixed> $data
     * @param int $id
     * @param string|null $eventAction
     * @param string|null $eventMessage
     * @return void
     */
    public function update(
        array $data,
        int $id,
        ?string $eventAction = 'update',
        ?string $eventMessage = 'O item foi editado.'
    ): void {
        $model = $this->get($id);

        $model->update($data);

        $this->afterUpdated($model, $data);

        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass($model, $eventAction, $eventMessage));
        }
    }

    /**
     * Remove um recurso.
     *
     * @param int $id
     * @param string|null $eventAction
     * @param string|null $eventMessage
     * @return void
     */
    public function remove(
        int $id,
        ?string $eventAction = 'remove',
        ?string $eventMessage = 'O item foi removido.'
    ): void {
        if ($this instanceof HasVersionsServiceInterface) {
            event(new $this->modelVersionEventClass($this->get($id), $eventAction, $eventMessage));
        }

        $this->modelClass::destroy($id);
    }

    /**
     * Gancho para antes da paginação do modelo.
     *
     * @param  Builder<Model>        $query
     * @param  array<string, mixed>  $data
     * @return Builder<Model>
     */
    protected function beforePagination(Builder $query, array $data): Builder
    {
        return $query;
    }

    /**
     * Gancho para após a criação do modelo.
     *
     * @param Model                 $model
     * @param array<string, mixed>  $data
     * @return Model
     */
    protected function afterCreated(Model $model, array $data): Model
    {
        return $model;
    }

    /**
     * Gancho para após a edição do modelo.
     *
     * @param Model                  $model
     * @param array<string, mixed>   $data
     * @return Model
     */
    protected function afterUpdated(Model $model, array $data): Model
    {
        return $model;
    }
}
