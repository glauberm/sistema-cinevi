<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserVersionEvent;
use App\Services\UserService;

class UserVersionListener
{
    public function __construct(private readonly UserService $service)
    {
    }

    public function handle(UserVersionEvent $event): void
    {
        $data = $event->user->toArray();

        $this->service->registerVersion($event->user, $event->action, $event->message, $data);
    }
}
