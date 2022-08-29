<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait CrudTestTrait
{
    /**
     * Testa a criação.
     *
     * @return void
     */
    public function testCreate(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $response = $this->json('POST', "{$this->baseApiUrl}/adicionar", $this->createRequest);

        $response->assertStatus(201);

        $this->assertDatabaseHas($this->tableName, $this->createDatabaseFields);

        if ($this instanceof HasVersionsTestInterface) {
            $this->assertDatabaseHas('versions', ['action' => 'create']);
        }
    }

    /**
     * Testa a paginação.
     *
     * @return void
     */
    public function testPaginate(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $model = $this->modelClass::factory()->create();

        $response = $this->json('GET', $this->baseApiUrl);

        $response->assertJson(['data' => [['id' => $model->id]]]);
    }

    /**
     * Testa a exibição.
     *
     * @return void
     */
    public function testShow(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $model = $this->modelClass::factory()->create();

        $response = $this->json('GET', "{$this->baseApiUrl}/{$model->id}");

        $response->assertJson(['data' => ['id' => $model->id]]);
    }

    /**
     * Testa a edição.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $model = $this->modelClass::factory()->create();

        $response = $this->json('PUT', "{$this->baseApiUrl}/{$model->id}/editar", $this->updateRequest);

        $response->assertOk();

        $this->assertDatabaseHas($this->tableName, $this->updateDatabaseFields);

        if ($this instanceof HasVersionsTestInterface) {
            $this->assertDatabaseHas('versions', ['action' => 'update']);
        }
    }

    /**
     * Testa a remoção.
     *
     * @return void
     */
    public function testRemove(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => \json_encode(['user', 'admin'])])
            ->createOne());

        $model = $this->modelClass::factory()->create();

        $response = $this->json('DELETE', "{$this->baseApiUrl}/{$model->id}/remover");

        $response = $this->json('GET', "{$this->baseApiUrl}/{$model->id}");

        $response->assertStatus(404);

        $this->assertDatabaseMissing($this->tableName, ['id' => $model->id]);

        if ($this instanceof HasVersionsTestInterface) {
            $this->assertDatabaseHas('versions', ['action' => 'remove']);
        }
    }

    /**
     * Testa o erro caso a tentiva de deleção seja feita por um usuário não-administrador.
     *
     * @return void
     */
    public function testRemoveIsAdminGate(): void
    {
        Sanctum::actingAs(User::factory()->createOne());

        $model = $this->modelClass::factory()->create();

        $this->json('DELETE', "{$this->baseApiUrl}/{$model->id}/remover");

        $response = $this->json('DELETE', "{$this->baseApiUrl}/{$model->id}/remover");

        $response->assertStatus(403);
    }
}
