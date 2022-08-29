<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserVersionEvent;
use App\Models\User;

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
     * Busca usuário por e-mail.
     *
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return $this->modelClass::where('email', '=', $email)->first();
    }
}
