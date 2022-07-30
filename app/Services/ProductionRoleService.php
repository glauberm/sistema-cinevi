<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\ProductionRoleRegisterVersionEvent;
use App\Models\ProductionRole;

class ProductionRoleService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = ProductionRole::class;

    protected string $modelRegisterVersionEventClass = ProductionRoleRegisterVersionEvent::class;

    protected string $modelVersionTableName = 'production_roles_versions';

    protected string $modelVersionIdColumnName = 'production_role_id';
}
