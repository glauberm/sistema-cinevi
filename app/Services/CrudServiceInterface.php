<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudServiceInterface
{
    /**
     * Ordena e pagina todos os dados.
     *
     * @param  mixed[] $data
     * @return LengthAwarePaginator
     */
    public function paginate(array $data): LengthAwarePaginator;

    /**
     * Adiciona um recurso.
     *
     * @param mixed[] $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Retorna um recurso.
     *
     * @param int $id
     * @return Model
     */
    public function get(int $id): Model;

    /**
     * Atualiza um recurso.
     *
     * @param mixed[] $data
     * @param int $id
     * @return void
     */
    public function update(array $data, int $id): void;

    /**
     * Remove um recurso.
     *
     * @param int $id
     * @return void
     */
    public function remove(int $id): void;
}
