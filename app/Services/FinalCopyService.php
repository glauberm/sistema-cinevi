<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\FinalCopyVersionEvent;
use App\Models\FinalCopy;

class FinalCopyService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = FinalCopy::class;

    protected string $modelVersionEventClass = FinalCopyVersionEvent::class;

    protected string $modelVersionTableName = 'final_copies_versions';

    protected string $modelVersionIdColumnName = 'final_copy_id';
}
