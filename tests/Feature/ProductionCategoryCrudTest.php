<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ProductionCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionCategoryCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'modalidades';
    }

    protected function getCreateRoute(): string
    {
        return 'modalidades/adicionar';
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
        $productionCategory = ProductionCategory::factory()
            ->createOne();

        return "modalidades/{$productionCategory->id}/editar";
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
        $productionCategory = ProductionCategory::factory()
            ->createOne();

        return "modalidades/{$productionCategory->id}/remover";
    }

    protected function getTableName(): string
    {
        return 'production_categories';
    }

    protected function getVersionsTableName(): string
    {
        return 'production_categories_versions';
    }
}
