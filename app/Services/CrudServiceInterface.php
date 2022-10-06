<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudServiceInterface
{
    public function paginate(Request $request): LengthAwarePaginator;

    /**
     * @param  array<string,mixed>  $data
     */
    public function create(array $data): Model;

    /**
     * @param  string[]  $relations
     */
    public function get(int $id, array $relations = []): Model;

    /**
     * @param  array<string,mixed>  $data
     */
    public function update(array $data, int $id): void;

    public function remove(int $id): void;
}
