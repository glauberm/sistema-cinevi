<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\FinalCopyVersionEvent;
use App\Models\FinalCopy;
use App\Models\FinalCopyProductionRole;

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

    /**
     * @param  FinalCopy            $finalCopy
     * @param  array<string,mixed>  $data
     * @return FinalCopy
     */
    public function afterCreated(FinalCopy $finalCopy, array $data): FinalCopy
    {
        if (\array_key_exists('production_roles', $data)) {
            /** @var array<int,array<string,mixed>> */
            $finalCopyProductionRoles = $data['production_roles'];

            $finalCopy->productionRoles()->createMany($finalCopyProductionRoles);
        }

        return $finalCopy;
    }

    /**
     * @param  FinalCopy            $finalCopy
     * @param  array<string,mixed>  $data
     * @return void
     */
    public function afterUpdated(FinalCopy $finalCopy, array $data): void
    {
        if (\array_key_exists('production_roles', $data)) {
            /** @var array<int,array<string,mixed>> */
            $finalCopyProductionRoles = $data['production_roles'];

            FinalCopyProductionRole::where('final_copy_id', '=', $finalCopy->id)
                ->whereNotIn('id', \array_column($finalCopyProductionRoles, 'id'))
                ->delete();

            for ($i = 0; $i < \count($finalCopyProductionRoles); $i++) {
                /** @var array<int,array<string,mixed>> */
                $users = $finalCopyProductionRoles[$i]['users'];

                $finalCopyProductionRole = FinalCopyProductionRole::updateOrCreate(
                    [
                        'id' => $finalCopyProductionRoles[$i]['id'],
                        'final_copy_id' => $finalCopy->id
                    ],
                    [
                        'order' => $i,
                        'production_role_id' => $finalCopyProductionRoles[$i]['production_role_id']
                    ],
                );

                $finalCopyProductionRole->users()->sync(\array_column($users, 'id'));
            }
        }
    }
}
