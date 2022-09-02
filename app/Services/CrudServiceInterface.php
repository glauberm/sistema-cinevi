<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudServiceInterface
{
    /**
     * @param  mixed[]  $data
     * @return LengthAwarePaginator
     */
    public function paginate(array $data): LengthAwarePaginator;

    /**
     * @param  mixed[]  $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param  integer  $id
     * @return Model
     */
    public function get(int $id): Model;

    /**
     * @param  mixed[]  $data
     * @param  integer  $id
     * @return void
     */
    public function update(array $data, int $id): void;

    /**
     * @param  integer  $id
     * @return void
     */
    public function remove(int $id): void;
}
