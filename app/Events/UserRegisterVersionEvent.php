<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\User;

class UserRegisterVersionEvent
{
    use Dispatchable;

    public User $user;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, string $action, string $message)
    {
        $this->user = $user;
        $this->action = $action;
        $this->message = $message;
    }
}
