<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ConfigurationUpdateRequest;
use App\Services\ConfigurationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;

class ConfigurationController extends Controller implements HasVersionsControllerInterface
{
    use HasVersionsControllerTrait;

    protected string $paginateVersionsView = 'pages/configuration/versions-index';

    protected string $showVersionView = 'pages/configuration/version';

    public function __construct(protected readonly ConfigurationService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function update(ConfigurationUpdateRequest $request): RedirectResponse
    {
        /** @var array<string,mixed> */
        $data = $request->validated();

        $this->service->update($data, 1);

        return Redirect::route('configuration');
    }
}
