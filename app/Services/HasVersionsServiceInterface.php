<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Version;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface HasVersionsServiceInterface
{
    /**
     * @param  integer               $id
     * @return LengthAwarePaginator
     */
    public function paginateVersions(int $id): LengthAwarePaginator;

    /**
     * @param  integer                 $id
     * @return Version
     */
    public function getVersion(int $id): Version;

    /**
     * @param Model                $model
     * @param string               $action
     * @param string               $message
     * @param array<string,mixed>  $payloadArray
     * @return void
     */
    public function registerVersion($model, string $action, string $message, array $payloadArray): void;
}
