<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ProductionRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionRoleTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    protected string $modelClass = ProductionRole::class;

    protected string $baseApiUrl = 'api/funcoes';

    protected string $tableName = 'production_roles';

    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        return [
            'title' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getCreateDatabaseFields(): array
    {
        return [
            'title' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        return [
            'title' => 'Consectur Lorem Ipsum Dolor Sit Amet',
            'description' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'title' => 'Consectur Lorem Ipsum Dolor Sit Amet',
            'description' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }
}
