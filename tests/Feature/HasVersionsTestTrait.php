<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait HasVersionsTestTrait
{
    /**
     * Testa a paginação de versões.
     *
     * @return void
     */
    public function testPaginateVersions(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => ['user', 'admin']])
            ->createOne());

        $model = $this->modelClass::factory()->create();

        $this->json('PUT', "{$this->baseApiUrl}/{$model->id}/editar", $this->getUpdateRequest());

        $response = $this->json('GET', "{$this->baseApiUrl}/{$model->id}/versoes");

        $response->assertOk();
    }
}
