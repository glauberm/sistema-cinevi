<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\FinalCopyVersionEvent;
use App\Services\FinalCopyService;

class FinalCopyVersionListener
{
    public FinalCopyService $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(FinalCopyService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param FinalCopyVersionEvent  $event
     * @return void
     */
    public function handle(FinalCopyVersionEvent $event)
    {
        $data = $event->finalCopy->toArray();

        $this->service->registerVersion($event->finalCopy, $event->action, $event->message, $data);
    }
}
