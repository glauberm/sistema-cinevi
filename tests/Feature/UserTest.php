<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    private string $modelClass = User::class;

    private string $baseApiUrl = 'api/usuarios';

    private string $tableName = 'users';

    /** @var array<string, string|string[]|boolean|null> */
    protected array $createRequest = [
        'name' => 'Glauber Mota',
        'email' => 'glaubernm@gmail.com',
        'password' => 'Gl@uber7!',
        'phone' => '(00) 71485-03148',
        'identifier' => '1304856',
        'is_enabled' => true,
        'is_confirmed' => true,
        'roles' => ['user'],
    ];

    /** @var array<string, string> */
    protected array $createDatabaseFields = [
        'name' => 'Glauber Mota',
    ];

    /** @var array<string, string|string[]|boolean|null> */
    protected array $updateRequest = [
        'name' => 'Glauber Urbealien',
        'email' => 'urbealien@gmail.com',
        'password' => '7Gl@uber!',
        'phone' => '(01) 71485-03148',
        'identifier' => '991304856',
        'is_enabled' => false,
        'is_confirmed' => false,
        'roles' => ['user', 'admin'],
    ];

    /** @var array<string, string> */
    protected array $updateDatabaseFields = [
        'name' => 'Glauber Urbealien',
    ];

    public function testCreate(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => \json_encode(['user', 'admin'])])
            ->createOne());

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
        Sanctum::actingAs(User::factory()
            ->state(['roles' => \json_encode(['user', 'admin'])])
            ->createOne());

        $model = $this->modelClass::factory()->create();

        $response = $this->json('GET', $this->baseApiUrl);

        $response->assertJson(['data' => [['id' => $model->id]]]);
    }

    /**
     * Testa a edição.
     *
     * @return void
     */
    public function testUpdate(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => \json_encode(['user', 'admin'])])
            ->createOne());

        $model = $this->modelClass::factory()->create();

        $response = $this->json('PUT', "{$this->baseApiUrl}/{$model->id}/editar", $this->updateRequest);

        $response->assertOk();

        $this->assertDatabaseHas($this->tableName, $this->updateDatabaseFields);

        if ($this instanceof HasVersionsTestInterface) {
            $this->assertDatabaseHas('versions', ['action' => 'update']);
        }
    }
}
