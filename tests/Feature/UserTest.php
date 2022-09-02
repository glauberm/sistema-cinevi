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

    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        return [
            'name' => 'Glauber Mota',
            'email' => 'glaubernm@gmail.com',
            'password' => 'Gl@uber7!',
            'phone' => '(00) 71485-03148',
            'identifier' => '1304856',
            'is_enabled' => true,
            'is_confirmed' => true,
            'roles' => ['user'],
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getCreateDatabaseFields(): array
    {
        return [
            'name' => 'Glauber Mota',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        return [
            'name' => 'Glauber Teste',
            'email' => 'teste@gmail.com',
            'password' => '7Gl@uber!',
            'phone' => '(01) 71485-03148',
            'identifier' => '991304856',
            'is_enabled' => false,
            'is_confirmed' => false,
            'roles' => ['user', 'admin'],
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'name' => 'Glauber Teste',
        ];
    }

    protected function createSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->state(['roles' => ['user', 'admin']])->createOne());
    }

    protected function paginateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => ['user', 'admin']])
            ->createOne());
    }

    protected function showSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => ['user', 'admin']])
            ->createOne());
    }

    protected function updateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => ['user', 'admin']])
            ->createOne());
    }

    protected function removeSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->state(['roles' => ['user', 'admin']])->createOne());
    }
}
