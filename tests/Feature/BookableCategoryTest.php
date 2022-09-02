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
