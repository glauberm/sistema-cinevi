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

    /** @var array<string, string> */
    protected array $createRequest = [
        'title' => 'Lorem Ipsum Dolor Sit Amet',
    ];

    /** @var array<string, string> */
    protected array $createDatabaseFields = [
        'title' => 'Lorem Ipsum Dolor Sit Amet',
    ];

    /** @var array<string, string> */
    protected array $updateRequest = [
        'title' => 'Consectur Lorem Ipsum Dolor Sit Amet',
    ];

    /** @var array<string, string> */
    protected array $updateDatabaseFields = [
        'title' => 'Consectur Lorem Ipsum Dolor Sit Amet',
    ];
}