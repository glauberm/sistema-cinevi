<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\FinalCopyVersionEvent;
use App\Services\FinalCopyService;

class FinalCopyVersionListener
{
    public function __construct(private readonly FinalCopyService $service)
    {
    }

    public function handle(FinalCopyVersionEvent $event): void
    {
        $data = $event->finalCopy->toArray();

        $data['owner'] = $event->finalCopy->owner->toArray();

        $data['production_category'] = $event->finalCopy
            ->productionCategory
            ->toArray();

        $data['professor'] = $event->finalCopy->professor->toArray();

        $this->service->registerVersion(
            $event->finalCopy,
            $event->action,
            $event->message,
            $data
        );
    }
}
