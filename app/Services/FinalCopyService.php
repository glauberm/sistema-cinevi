<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\FinalCopyVersionEvent;
use App\Models\FinalCopy;
use App\Models\FinalCopyProductionRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FinalCopyService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::get as baseGet;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = FinalCopy::class;

    protected string $modelVersionEventClass = FinalCopyVersionEvent::class;

    protected string $modelVersionTableName = 'final_copies_versions';

    protected string $modelVersionIdColumnName = 'final_copy_id';

    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @param  string[]  $relations
     */
    public function get(int $id, array $relations = ['owner', 'productionCategory', 'professor']): FinalCopy
    {
        /** @var FinalCopy $finalCopy */
        $finalCopy = $this->baseGet($id, $relations);

        return $finalCopy;
    }

    /**
     * @param  Builder<FinalCopy>  $query
     * @return Builder<FinalCopy>
     */
    protected function beforePagination(Builder $query, Request $request): Builder
    {
        if (is_string($request->input('status'))) {
            switch ($request->input('status')) {
                case 'owned_only':
                    $query->where(
                        'owner_id',
                        '=',
                        $this->authService->getAuthIdOrFail()
                    );
                    break;
            }
        }

        return $query;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterCreated(FinalCopy $finalCopy, array $data): FinalCopy
    {
        if (
            array_key_exists('production_roles', $data)
            && is_array($data['production_roles'])
        ) {
            /** @var array<int,array<string,mixed>> */
            $finalCopyProductionRoles = $data['production_roles'];

            for ($i = 0; $i < count($finalCopyProductionRoles); $i++) {
                $finalCopy->productionRoles()->attach(
                    array_column(
                        $finalCopyProductionRoles,
                        'production_role_id'
                    ),
                    ['order' => $i]
                );
            }

            foreach ($finalCopy->productionRoles as $finalCopyProductionRole) {
                $finalCopyProductionRole->pivot->users()->attach(
                    array_column($finalCopyProductionRole['users'], 'id')
                );
            }

            dd($finalCopy);
        }

        return $finalCopy;
    }

    /**
     * @param  array<string,mixed>  $data
     */
    protected function afterUpdated(FinalCopy $finalCopy, array $data): void
    {
        if (
            array_key_exists('production_roles', $data)
            && is_array($data['production_roles'])
        ) {
            /** @var array<int,array<string,mixed>> */
            $finalCopyProductionRoles = $data['production_roles'];

            FinalCopyProductionRole::where('final_copy_id', '=', $finalCopy->id)
                ->whereNotIn(
                    'id',
                    array_column($finalCopyProductionRoles, 'id')
                )
                ->delete();

            for ($i = 0; $i < count($finalCopyProductionRoles); $i++) {
                /** @var array<int,array<string,mixed>> */
                $users = $finalCopyProductionRoles[$i]['users'];

                $finalCopyProductionRole = FinalCopyProductionRole::updateOrCreate(
                    [
                        'id' => $finalCopyProductionRoles[$i]['id'],
                        'final_copy_id' => $finalCopy->id,
                    ],
                    [
                        'order' => $i,
                        'production_role_id' => $finalCopyProductionRoles[$i]['production_role_id'],
                    ],
                );

                $finalCopyProductionRole->users()
                    ->sync(array_column($users, 'id'));
            }
        }
    }
}