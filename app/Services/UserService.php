<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserVersionEvent;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

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
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return $this->modelClass::where('email', '=', $email)->first();
    }

    /**
     * @param  string $role
     * @return Collection<int,User>
     */
    public function getAllWithRole(string $role): Collection
    {
        return $this->modelClass::whereJsonContains('roles', $role)->get();
    }
}
