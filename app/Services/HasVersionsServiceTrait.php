<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Version;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait HasVersionsServiceTrait
{
    /**
     * @param  int  $id
     * @return LengthAwarePaginator
     */
    public function paginateVersions(int $id): LengthAwarePaginator
    {
        $versionsIds = $this->queryVersionsByModel($id)
            ->pluck('version_id')
            ->toArray();

        return Version::whereIn('id', $versionsIds)
            ->orderBy('datetime', 'desc')
            ->paginate(10, ['*'], 'page');
    }

    /**
     * @param  int  $id
     * @return Version
     *
     * @throws ModelNotFoundException
     */
    public function getVersion(int $id): Version
    {
        return Version::findOrFail($id);
    }

    /**
     * Cria uma nova versão de um item. Se já houver versões do item e a versão for de edição, checa se houveram
     * alterações no item antes de criar a nova versão.
     *
     * @param  Model  $model
     * @param  string  $action
     * @param  string  $message
     * @param  array<string,mixed>  $payload
     * @return void
     */
    public function registerVersion($model, string $action, string $message, array $payload): void
    {
        $modelId = $model->getAttribute('id');

        if (! \is_int($modelId)) {
            throw new \InvalidArgumentException('O identificador do modelo deve ser um inteiro.');
        }

        $lastModelVersion = $this->queryVersionsByModel($modelId)->first();

        if ($lastModelVersion instanceof Model) {
            $lastModelVersionId = $lastModelVersion->getAttribute('version_id');

            $lastVersion = Version::where('id', '=', $lastModelVersionId)->firstOrFail();

            if ($action === 'update') {
                if ($lastVersion->payload !== $payload) {
                    $this->createVersion($modelId, $action, $message, $payload);
                }
            } else {
                $this->createVersion($modelId, $action, $message, $payload);
            }
        } else {
            $this->createVersion($modelId, $action, $message, $payload);
        }
    }

    /**
     * @param  int  $id
     * @param  string  $action
     * @param  string  $message
     * @param  array<string,mixed>  $payload
     * @return void
     */
    private function createVersion(int $id, string $action, string $message, array $payload): void
    {
        $version = Version::create([
            'action' => $action,
            'message' => $message,
            'payload' => $payload,
            'user_id' => Auth::id(),
            'user_ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_string' => Auth::user() ? Auth::user()->name : 'not_authenticated',
            'datetime' => CarbonImmutable::now(),
        ]);

        DB::table($this->modelVersionTableName)->insert([
            $this->modelVersionIdColumnName => $id,
            'version_id' => $version->id,
        ]);
    }

    /**
     * @param  int  $id
     * @return Builder
     */
    private function queryVersionsByModel(int $id): Builder
    {
        return DB::table($this->modelVersionTableName)
            ->join('versions', 'versions.id', '=', $this->modelVersionTableName.'.version_id')
            ->where($this->modelVersionTableName.'.'.$this->modelVersionIdColumnName, '=', $id)
            ->orderBy('versions.datetime', 'desc');
    }
}
