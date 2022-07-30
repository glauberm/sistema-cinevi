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
            if (!\is_array($user->roles)) {
                throw new \TypeError('Os papéis do usuário não são um array.');
            }

            return \in_array('admin', $user->roles, true);
        });

        Gate::define('isDepartment', function ($user) {
            if (!\is_array($user->roles)) {
                throw new \TypeError('Os papéis do usuário não são um array.');
            }

            return \in_array('department', $user->roles, true);
        });

        Gate::define('isWarehouse', function ($user) {
            if (!\is_array($user->roles)) {
                throw new \TypeError('Os papéis do usuário não são um array.');
            }

            return \in_array('warehouse', $user->roles, true);
        });
    }
}
