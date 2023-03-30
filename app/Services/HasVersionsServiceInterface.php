<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Version;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface HasVersionsServiceInterface
{
    /**
     * @return LengthAwarePaginator<Version>
     */
    public function paginateVersions(int $id): LengthAwarePaginator;

    public function getVersion(int $id): Version;

    /**
     * @param  array<string,mixed>  $payloadArray
     */
    public function registerVersion(Model $model, string $action, string $message, array $payloadArray): void;
}
