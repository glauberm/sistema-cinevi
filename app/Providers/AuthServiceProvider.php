<?php

namespace App\Providers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        Gate::define('hasRole', function (User $user, UserRole $role) {
            return \in_array($role, $user->roles, true);
        });

        Gate::define('isUser', function (User $user, int $userId) {
            return $user->id === $userId;
        });

        Gate::define('isNotUser', function (User $user, int $userId) {
            return $user->id !== $userId;
        });
    }
}
