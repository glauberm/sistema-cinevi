<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Events\UserVersionEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserService implements CrudServiceInterface, HasVersionsServiceInterface
{
    use CrudServiceTrait, HasVersionsServiceTrait {
        CrudServiceTrait::create as baseCreate;
        CrudServiceTrait::update as baseUpdate;
    }

    protected string $modelClass = User::class;

    protected string $modelVersionEventClass = UserVersionEvent::class;

    protected string $modelVersionTableName = 'users_versions';

    protected string $modelVersionIdColumnName = 'user_id';

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    protected function beforePagination(Builder $query, Request $request): Builder
    {
        if (is_string($request->input('name'))) {
            $query->where('name', 'like', "%{$request->input('name')}%");
        }

        if (is_string($request->input('status'))) {
            switch ($request->input('status')) {
                case 'disabled_only':
                    $query->where('is_enabled', '=', false);
                    break;
                case 'unconfirmed_only':
                    $query->where('is_confirmed', '=', false);
                    break;
            }
        }

        if (is_string($request->input('role'))) {
            $query->whereJsonContains('roles', $request->input('role'));
        }

        return $query;
    }

    public function getByEmail(string $email): ?User
    {
        return $this->modelClass::where('email', '=', $email)->first();
    }

    /**
     * @return Collection<int,User>
     */
    public function getAllWithRole(UserRole $role): Collection
    {
        return $this->modelClass::whereJsonContains('roles', $role)->get();
    }

    public function hasRole(User $user, UserRole $role): bool
    {
        return in_array($role, $user->roles);
    }

    public function isOrdinary(User $user): bool
    {
        return !in_array(UserRole::Admin->value, $user->roles)
            && !in_array(UserRole::Department->value, $user->roles)
            && !in_array(UserRole::Warehouse->value, $user->roles)
            && !in_array(UserRole::Professor->value, $user->roles);
    }
}
