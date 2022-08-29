<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\BookableCategory;
use Illuminate\Foundation\Events\Dispatchable;

class BookableCategoryVersionEvent
{
    use Dispatchable;

    public BookableCategory $bookableCategory;

    public string $action;

    public string $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BookableCategory $bookableCategory, string $action, string $message)
    {
        $this->bookableCategory = $bookableCategory;

        $this->action = $action;

        $this->message = $message;
    }
}
