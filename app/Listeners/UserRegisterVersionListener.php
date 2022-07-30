<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserRegisterVersionEvent;
use App\Services\UserService;

class UserRegisterVersionListener
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
     * @param UserRegisterVersionEvent  $event
     * @return void
     */
    public function handle(UserRegisterVersionEvent $event)
    {
        $data = $event->user->makeHidden('deleted_at')->toArray();

        $this->service->registerVersion($event->user, $event->action, $event->message, $data);
    }
}
