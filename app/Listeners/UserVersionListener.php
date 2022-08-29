<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserVersionEvent;
use App\Services\UserService;

class UserVersionListener
{
    public UserService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param UserVersionEvent  $event
     * @return void
     */
    public function handle(UserVersionEvent $event)
    {
        $data = $event->user->toArray();

        $this->service->registerVersion($event->user, $event->action, $event->message, $data);
    }
}
