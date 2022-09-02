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
        Gate::define('hasRole', function (User $user, string $role) {
            return \in_array($role, $user->roles, true);
        });

        Gate::define('isNotUser', function (User $user, int $userId) {
            return $user->id !== $userId;
        });
    }
}
