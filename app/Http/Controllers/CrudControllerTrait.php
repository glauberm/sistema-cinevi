<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;

trait CrudControllerTrait
{
    protected string $createdMessage = 'O item foi criado com sucesso.';

    protected string $updatedMessage = 'O item foi editado com sucesso.';

    protected string $removedMessage = 'O item foi removido com sucesso.';

    public function paginate(Request $request): View
    {
        return ViewFacade::make($this->paginateView, [
            'data' => $this->service->paginate($request)
        ]);
    }

    public function doCreate(FormRequest $request): RedirectResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $model = $this->service->create($data);

        /** @phpstan-ignore-next-line */
        $this->afterCreated($request, $model);

        return Redirect::route($this->paginateRoute);
    }

    public function doUpdate(FormRequest $request, int $id): RedirectResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->service->update($data, $id);

        /** @phpstan-ignore-next-line */
        $this->afterUpdated($request, $id);

        return Redirect::route($this->paginateRoute);
    }

    public function doRemove(FormRequest $request, int $id): RedirectResponse
    {
        $this->service->remove($id);

        return Redirect::route($this->paginateRoute);
    }

    protected function afterCreated(FormRequest $request, Model $model): void
    {
    }

    protected function afterUpdated(FormRequest $request, int $id): void
    {
    }
}
