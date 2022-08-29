<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\FinalCopy;
use Illuminate\Foundation\Events\Dispatchable;

class FinalCopyVersionEvent
{
    use Dispatchable;

    public FinalCopy $finalCopy;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FinalCopy $finalCopy, string $action, string $message)
    {
        $this->finalCopy = $finalCopy;

        $this->action = $action;

        $this->message = $message;
    }
}
