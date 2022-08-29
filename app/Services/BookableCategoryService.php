<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\BookableCategoryVersionEvent;
use App\Models\BookableCategory;

class BookableCategoryService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = BookableCategory::class;

    protected string $modelVersionEventClass = BookableCategoryVersionEvent::class;

    protected string $modelVersionTableName = 'bookable_categories_versions';

    protected string $modelVersionIdColumnName = 'bookable_category_id';
}
