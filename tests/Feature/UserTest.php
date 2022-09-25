<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
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
    protected function getUpdateRequest(): array
    {
        return [
            'name' => 'Glauber Teste',
            'email' => 'teste@gmail.com',
            'password' => '7Gl@uber!',
            'phone' => '17148503148',
            'identifier' => '991304856',
            'is_enabled' => false,
            'is_confirmed' => false,
            'roles' => [UserRole::Admin],
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'name' => 'Glauber Teste',
            'email' => 'teste@gmail.com',
            'phone' => '17148503148',
            'identifier' => '991304856',
        ];
    }

    protected function paginateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => [UserRole::Admin]])
            ->createOne());
    }

    protected function showSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => [UserRole::Admin]])
            ->createOne());
    }

    protected function updateSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()
            ->state(['roles' => [UserRole::Admin]])
            ->createOne());
    }

    protected function removeSanctumActingAs(): void
    {
        Sanctum::actingAs(User::factory()->state(['roles' => [UserRole::Admin]])->createOne());
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->markTestSkipped('Os usuários só podem ser criados através do cadastro.');
    }
}
