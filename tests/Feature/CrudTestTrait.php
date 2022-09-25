<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait CrudTestTrait
{
    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        return [];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getCreateDatabaseFields(): array
    {
        return [];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        return [];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [];
    }

    protected function createSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->createOne());
    }

    protected function paginateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->createOne());
    }

    protected function showSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->createOne());
    }

    protected function updateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->createOne());
    }

    protected function removeSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->state(['roles' => [UserRole::Admin]])->createOne());
    }

    /**
     * Testa a criação.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $this->createSanctumActingAs();

        $response = $this->json('POST', "{$this->baseApiUrl}/adicionar", $this->getCreateRequest());

        $response->assertStatus(201);

        $this->assertDatabaseHas($this->tableName, $this->getCreateDatabaseFields());

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
        $this->paginateSanctumActingAs();

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
        $this->showSanctumActingAs();

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
        $this->updateSanctumActingAs();

        $model = $this->modelClass::factory()->create();

        $response = $this->json('PUT', "{$this->baseApiUrl}/{$model->id}/editar", $this->getUpdateRequest());

        $response->assertOk();

        $this->assertDatabaseHas($this->tableName, $this->getUpdateDatabaseFields());

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
        $this->removeSanctumActingAs();

        $model = $this->modelClass::factory()->create();

        $response = $this->json('DELETE', "{$this->baseApiUrl}/{$model->id}/remover");

        $response = $this->json('GET', "{$this->baseApiUrl}/{$model->id}");

        $response->assertStatus(404);

        $this->assertDatabaseMissing($this->tableName, ['id' => $model->id]);

        if ($this instanceof HasVersionsTestInterface) {
            $this->assertDatabaseHas('versions', ['action' => 'remove']);
        }
    }
}
