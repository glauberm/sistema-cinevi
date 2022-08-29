<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\ProductionCategoryVersionEvent;
use App\Models\ProductionCategory;

class ProductionCategoryService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = ProductionCategory::class;

    protected string $modelVersionEventClass = ProductionCategoryVersionEvent::class;

    protected string $modelVersionTableName = 'production_categories_versions';

    protected string $modelVersionIdColumnName = 'production_category_id';
}
