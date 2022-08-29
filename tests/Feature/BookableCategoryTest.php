<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\BookableCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookableCategoryTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    protected string $modelClass = BookableCategory::class;

    protected string $baseApiUrl = 'api/categorias-de-reservaveis';

    protected string $tableName = 'bookable_categories';

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
        'description' => 'Lorem Ipsum Dolor Sit Amet',
    ];

    /** @var array<string, string> */
    protected array $updateDatabaseFields = [
        'title' => 'Consectur Lorem Ipsum Dolor Sit Amet',
        'description' => 'Lorem Ipsum Dolor Sit Amet',
    ];
}
