<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudServiceInterface
{
    /**
     * @param  Request  $request
     * @return LengthAwarePaginator
     */
    public function paginate(Request $request): LengthAwarePaginator;

    /**
     * @param  mixed[]  $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param  int  $id
     * @return Model
     */
    public function get(int $id): Model;

    /**
     * @param  mixed[]  $data
     * @param  int  $id
     * @return void
     */
    public function update(array $data, int $id): void;

    /**
     * @param  int  $id
     * @return void
     */
    public function remove(int $id): void;
}
