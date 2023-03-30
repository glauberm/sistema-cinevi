<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\ProductionRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionRoleCrudTest extends CrudTestCase
{
    use RefreshDatabase;

    protected function getIndexRoute(): string
    {
        return 'funcoes';
    }

    protected function getCreateRoute(): string
    {
        return 'funcoes/adicionar';
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
        $productionRole = ProductionRole::factory()
            ->createOne();

        return "funcoes/{$productionRole->id}/editar";
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
        $productionRole = ProductionRole::factory()
            ->createOne();

        return "funcoes/{$productionRole->id}/remover";
    }

    protected function getTableName(): string
    {
        return 'production_roles';
    }

    protected function getVersionsTableName(): string
    {
        return 'production_roles_versions';
    }
}
