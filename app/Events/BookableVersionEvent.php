<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Bookable;
use Illuminate\Foundation\Events\Dispatchable;

class BookableVersionEvent
{
    use Dispatchable;

    public Bookable $bookable;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Bookable $bookable, string $action, string $message)
    {
        $this->bookable = $bookable;

        $this->action = $action;

        $this->message = $message;
    }
}
