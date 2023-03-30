<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->get('usuarios')
            ->assertOk();
    }

    public function testUpdateView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->get("usuarios/{$user->id}/editar")
            ->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->post("usuarios/{$user->id}/editar", [
                'name' => 'Lorem Ipsum',
                'email' => 'glaubernm@gmail.com',
                'phone' => '21997963685',
                'identifier' => '123456789',
                'is_confirmed' => true,
                'roles' => [],
            ])
            ->assertStatus(302)
            ->assertRedirect('usuarios');

        $this->assertDatabaseHas('users', [
            'name' => 'Lorem Ipsum',
            'email' => 'glaubernm@gmail.com',
            'phone' => '21997963685',
            'identifier' => '123456789',
            'is_confirmed' => true,
            'roles' => [],
        ]);

        $this->assertDatabaseCount('users_versions', 1);
    }

    public function testRemove(): void
    {
        $actingUser = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($actingUser)
            ->post("usuarios/{$user->id}/remover")
            ->assertStatus(302)
            ->assertRedirect('usuarios');

        $this->assertDatabaseCount('users', 1);

        $this->assertDatabaseCount('users_versions', 1);
    }
}
