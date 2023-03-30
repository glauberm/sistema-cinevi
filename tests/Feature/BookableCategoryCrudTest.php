<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\BookableCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookableCategoryCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'categorias-de-reservaveis';
    }

    protected function getCreateRoute(): string
    {
        return 'categorias-de-reservaveis/adicionar';
    }

    protected function getCreateData(): array
    {
        return [
            'title' => 'Lorem Ipsum',
            'description' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }

    protected function getUpdateRoute(): string
    {
        $bookableCategory = BookableCategory::factory()
            ->createOne();

        return "categorias-de-reservaveis/{$bookableCategory->id}/editar";
    }

    protected function getUpdateData(): array
    {
        return [
            'title' => 'Lorem Ipsum',
            'description' => 'Lorem Ipsum Dolor Sit Amet',
        ];
    }

    protected function getRemoveRoute(): string
    {
        $bookableCategory = BookableCategory::factory()
            ->createOne();

        return "categorias-de-reservaveis/{$bookableCategory->id}/remover";
    }

    protected function getTableName(): string
    {
        return 'bookable_categories';
    }

    protected function getVersionsTableName(): string
    {
        return 'bookable_categories_versions';
    }
}
