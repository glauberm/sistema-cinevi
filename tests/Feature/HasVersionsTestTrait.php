<?php

declare(strict_types=1);

namespace Tests\Feature;

trait HasVersionsTestTrait
{
    /**
     * Testa a paginação de versões.
     *
     * @return void
     */
    public function testPaginateVersions(): void
    {
        $model = $this->modelClass::factory()->create();

        $this->json('PUT', "{$this->baseApiUrl}/{$model->id}/editar", $this->updateRequest);

        $response = $this->json('GET', "{$this->baseApiUrl}/{$model->id}/versoes");

        $response->assertOk();
    }
}
