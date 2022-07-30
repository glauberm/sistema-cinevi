<?php

namespace App\Providers;

use App\Events\ProductionRoleRegisterVersionEvent;
use App\Events\UserRegisterVersionEvent;
use App\Listeners\ProductionRoleRegisterVersionListener;
use App\Listeners\UserRegisterVersionListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegisterVersionEvent::class => [UserRegisterVersionListener::class],
        ProductionRoleRegisterVersionEvent::class => [ProductionRoleRegisterVersionListener::class],
    ];
}
