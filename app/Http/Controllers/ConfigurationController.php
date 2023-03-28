<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ConfigurationUpdateRequest;
use App\Services\ConfigurationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class ConfigurationController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    public function __construct(
        protected readonly ConfigurationService $service
    ) {
        $this->middleware(Authenticate::class);
    }

    public function update(
        ConfigurationUpdateRequest $request,
        int $id
    ): RedirectResponse {
        return $this->doUpdate($request, $id);
    }
}
