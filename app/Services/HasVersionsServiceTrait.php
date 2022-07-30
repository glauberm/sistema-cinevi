<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Version;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait HasVersionsServiceTrait
{
    /**
     * Ordena e pagina todas as versões de um item.
     *
     * @param int $id
     * @return LengthAwarePaginator
     */
    public function paginateVersions(int $id): LengthAwarePaginator
    {
        $versionsIds = $this->queryVersionsByModel($id)
            ->pluck('version_id')
            ->toArray();

        return Version::whereIn('id', $versionsIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page');
    }

    /**
     * Retorna uma versão de um item;
     *
     * @param int $id
     * @return Version
     * @throws ModelNotFoundException
     */
    public function getVersion(int $id): Version
    {
        return Version::findOrFail($id);
    }

    /**
     * Cria uma nova versão de um item. Se já houver versões do item e a versão
     * for de criação ou edição, checa se houveram alterações nele antes de
     * criar a nova versão.
     *
     * @param Model         $model
     * @param string                $action
     * @param string                $message
     * @param array<string, mixed>  $payloadArray
     * @return void
     */
    public function registerVersion($model, string $action, string $message, array $payloadArray): void
    {
        $payload = \json_encode($payloadArray, \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);

        if ($payload === false) {
            throw new \JsonException('Erro ao codificar payload da versão.');
        }

        /** @phpstan-ignore-next-line */
        $modelId = $model->id;

        if (!\is_int($modelId)) {
            throw new \TypeError('O identificador do modelo não é um inteiro.');
        }

        if ($lastModelVersion = $this->queryVersionsByModel($modelId)->first()) {
            if (!\property_exists($lastModelVersion, 'version_id')) {
                throw new \InvalidArgumentException('O identificador da versão do modelo não está presente.');
            }

            $lastVersion = Version::where('id', '=', $lastModelVersion->version_id)->firstOrFail();

            if (!\is_string($lastVersion->payload)) {
                throw new \TypeError('O payload da versão não é uma string.');
            }

            if ($action === 'create' || $action === 'update') {
                if (!(\json_decode($lastVersion->payload, true) === $payloadArray)) {
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
     * Adiciona uma versão de um item.
     *
     * @param int $id
     * @param string $action
     * @param string $message
     * @param string $payload
     * @return void
     */
    private function createVersion(int $id, string $action, string $message, string $payload): void
    {
        $version = Version::create([
            'payload' => $payload,
            'user_id' => Auth::id(),
            'user_ip' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_string' => Auth::user() ? Auth::user()->email : 'not_authenticated',
            'action' => $action,
            'message' => $message,
        ]);

        DB::table($this->modelVersionTableName)->insert([
            $this->modelVersionIdColumnName => $id,
            'version_id' => $version->id,
        ]);
    }

    /**
     * Busca na tabela de versões através do id do tipo do item da versão.
     *
     * @param int $id
     * @return Builder
     */
    private function queryVersionsByModel(int $id): Builder
    {
        return DB::table($this->modelVersionTableName)
            ->join('versions', 'versions.id', '=', $this->modelVersionTableName . '.version_id')
            ->where($this->modelVersionTableName . '.' . $this->modelVersionIdColumnName, '=', $id)
            ->orderBy('versions.created_at', 'desc');
    }
}
