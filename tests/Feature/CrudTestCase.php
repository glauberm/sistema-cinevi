<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Tests\TestCase;

abstract class CrudTestCase extends TestCase
{
    public function testIndex(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->get($this->getIndexRoute())
            ->assertOk();
    }

    public function testCreateView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->get($this->getCreateRoute())
            ->assertOk();
    }

    public function testCreate(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $createData = $this->getCreateData();

        $this->actingAs($user)
            ->post($this->getCreateRoute(), $createData)
            ->assertStatus(302)
            ->assertRedirect($this->getIndexRoute());

        $this->assertDatabaseHas(
            $this->getTableName(),
            $this->getCreatedData($createData)
        );

        $this->assertDatabaseCount($this->getVersionsTableName(), 1);

        $this->additionalCreateAssertions();
    }

    public function testUpdateView(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->get($this->getUpdateRoute())
            ->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $updateData = $this->getUpdateData();

        $this->actingAs($user)
            ->post($this->getUpdateRoute(), $updateData)
            ->assertStatus(302)
            ->assertRedirect($this->getIndexRoute());

        $this->assertDatabaseHas(
            $this->getTableName(),
            $this->getUpdatedData($updateData)
        );

        $this->assertDatabaseCount($this->getVersionsTableName(), 1);

        $this->additionalUpdateAssertions();
    }

    public function testRemove(): void
    {
        $user = User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        $this->actingAs($user)
            ->post($this->getRemoveRoute())
            ->assertStatus(302)
            ->assertRedirect($this->getIndexRoute());

        $this->assertDatabaseCount($this->getTableName(), 0);

        $this->assertDatabaseCount($this->getVersionsTableName(), 1);

        $this->additionalRemoveAssertions();
    }

    abstract protected function getIndexRoute(): string;

    abstract protected function getCreateRoute(): string;

    abstract protected function getCreateData(): array;

    abstract protected function getUpdateRoute(): string;

    abstract protected function getUpdateData(): array;

    abstract protected function getRemoveRoute(): string;

    abstract protected function getTableName(): string;

    abstract protected function getVersionsTableName(): string;

    protected function getCreatedData(array $createData): array
    {
        return $createData;
    }

    protected function getUpdatedData(array $updateData): array
    {
        return $updateData;
    }

    protected function additionalCreateAssertions(): void
    {
        return;
    }

    protected function additionalUpdateAssertions(): void
    {
        return;
    }

    protected function additionalRemoveAssertions(): void
    {
        return;
    }
}
