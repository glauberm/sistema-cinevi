<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Version;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

interface HasVersionsServiceInterface
{
    /**
     * Ordena e pagina todas as versões de um item.
     *
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function paginateVersions(int $id): LengthAwarePaginator;

    /**
     * Retorna uma versão de um item;
     *
     * @param int        $id
     * @return Version
     * @throws ModelNotFoundException
     */
    public function getVersion(int $id): Version;

    /**
     * Cria uma nova versão de um item.
     *
     * @param Model         $model
     * @param string                $action
     * @param string                $message
     * @param array<string, mixed>  $payloadArray
     * @return void
     */
    public function registerVersion($model, string $action, string $message, array $payloadArray): void;
}
