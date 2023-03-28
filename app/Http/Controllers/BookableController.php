<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\BookableCreateOrUpdateRequest;
use App\Http\Requests\BookableRemoveRequest;
use App\Mail\BookableUnderMaintenanceMail;
use App\Mail\BookableWithReturnOverdueMail;
use App\Services\BookableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class BookableController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    private ?bool $isUnderMaintenanceBeforeUpdate = null;

    private ?bool $isReturnOverdueBeforeUpdate = null;

    public function __construct(protected readonly BookableService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function create(
        BookableCreateOrUpdateRequest $request
    ): RedirectResponse {
        return $this->doCreate($request);
    }

    public function update(
        BookableCreateOrUpdateRequest $request,
        int $id
    ): RedirectResponse {
        /** @var array<string,mixed> $data */
        $data = $request->validated();

        $this->isUnderMaintenanceBeforeUpdate = $data['is_under_maintenance'] === true;

        $this->isReturnOverdueBeforeUpdate = $data['is_return_overdue'] === true;

        return $this->doUpdate($request, $id);
    }

    public function remove(
        BookableRemoveRequest $request,
        int $id
    ): RedirectResponse {
        return $this->doRemove($request, $id);
    }

    protected function afterUpdated(
        BookableCreateOrUpdateRequest $request,
        int $id
    ): void {
        $bookable = $this->service->get($id, ['owner']);

        if (
            $this->isUnderMaintenanceBeforeUpdate === false
            && $bookable->is_under_maintenance === true
        ) {
            foreach ($bookable->bookings as $booking) {
                Mail::to($booking->project->owner->email)
                    ->queue(
                        new BookableUnderMaintenanceMail($bookable, $booking)
                    );
            }
        }

        if (
            $this->isReturnOverdueBeforeUpdate === false
            && $bookable->is_return_overdue === true
        ) {
            foreach ($bookable->bookings as $booking) {
                Mail::to($booking->project->owner->email)
                    ->queue(
                        new BookableWithReturnOverdueMail($bookable, $booking)
                    );
            }
        }
    }
}
