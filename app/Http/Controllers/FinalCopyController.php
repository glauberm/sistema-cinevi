<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\FinalCopyCreateOrUpdateRequest;
use App\Http\Requests\FinalCopyRemoveRequest;
use App\Services\FinalCopyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class FinalCopyController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $paginateRoute = 'final-copy.index';

    protected string $paginateView = 'pages/final-copy/index';

    protected string $paginateVersionsView = 'pages/final-copy/versions-index';

    protected string $showVersionView = 'pages/final-copy/version';

    public function __construct(protected readonly FinalCopyService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function create(FinalCopyCreateOrUpdateRequest $request): RedirectResponse
    {
        return $this->doCreate($request);
    }

    public function update(FinalCopyCreateOrUpdateRequest $request, int $id): RedirectResponse
    {
        return $this->doUpdate($request, $id);
    }

    public function remove(FinalCopyRemoveRequest $request, int $id): RedirectResponse
    {
        return $this->doRemove($request, $id);
    }
}
