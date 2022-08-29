<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('isAdmin', function (User $user) {
            $roles = $user->roles;

            if (\is_string($roles)) {
                throw new \TypeError('Os papéis do usuário não são um array.');
            }

            return \in_array('admin', $roles, true);
        });

        Gate::define('isNotUser', function (User $user, User $userModel) {
            return $user !== $userModel;
        });

        Gate::define('isDepartment', function ($user) {
            $roles = $user->roles;

            if (\is_string($roles)) {
                throw new \TypeError('Os papéis do usuário não são um array.');
            }

            return \in_array('department', $roles, true);
        });

        Gate::define('isWarehouse', function ($user) {
            $roles = $user->roles;

            if (\is_string($roles)) {
                throw new \TypeError('Os papéis do usuário não são um array.');
            }

            return \in_array('warehouse', $roles, true);
        });
    }
}
