<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;

trait HasVersionsControllerTrait
{
    public function paginateVersions(Request $request, int $id): View
    {
        return ViewFacade::make($this->paginateVersionsView, [
            'data' => $this->service->paginateVersions($id)
        ]);
    }

    public function showVersion(Request $request, int $id): View
    {
        return ViewFacade::make($this->showVersionView, [
            'data' => $this->service->getVersion($id)
        ]);
    }
}
