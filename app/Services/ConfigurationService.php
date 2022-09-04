<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\ConfigurationVersionEvent;
use App\Models\Configuration;

class ConfigurationService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = Configuration::class;

    protected string $modelVersionEventClass = ConfigurationVersionEvent::class;

    protected string $modelVersionTableName = 'configurations_versions';

    protected string $modelVersionIdColumnName = 'configuration_id';
}
