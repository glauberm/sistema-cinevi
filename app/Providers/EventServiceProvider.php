<?php

namespace App\Providers;

use App\Events\BookableCategoryVersionEvent;
use App\Events\BookableVersionEvent;
use App\Events\BookingVersionEvent;
use App\Events\ConfigurationVersionEvent;
use App\Events\FinalCopyVersionEvent;
use App\Events\ProductionCategoryVersionEvent;
use App\Events\ProductionRoleVersionEvent;
use App\Events\ProjectVersionEvent;
use App\Events\UserVersionEvent;
use App\Listeners\BookableCategoryVersionListener;
use App\Listeners\BookableVersionListener;
use App\Listeners\BookingVersionListener;
use App\Listeners\ConfigurationVersionListener;
use App\Listeners\FinalCopyVersionListener;
use App\Listeners\ProductionCategoryVersionListener;
use App\Listeners\ProductionRoleVersionListener;
use App\Listeners\ProjectVersionListener;
use App\Listeners\UserVersionListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,array<int,class-string>>
     */
    protected $listen = [
        BookableCategoryVersionEvent::class => [BookableCategoryVersionListener::class],
        BookableVersionEvent::class => [BookableVersionListener::class],
        BookingVersionEvent::class => [BookingVersionListener::class],
        ConfigurationVersionEvent::class => [ConfigurationVersionListener::class],
        FinalCopyVersionEvent::class => [FinalCopyVersionListener::class],
        ProductionCategoryVersionEvent::class => [ProductionCategoryVersionListener::class],
        ProductionRoleVersionEvent::class => [ProductionRoleVersionListener::class],
        ProjectVersionEvent::class => [ProjectVersionListener::class],
        UserVersionEvent::class => [UserVersionListener::class],
    ];
}
