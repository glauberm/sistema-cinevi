<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\ConfigurationUpdateRequest;
use App\Http\Resources\Configuration;
use App\Services\ConfigurationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ConfigurationController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Configuration::class;

    public function __construct(protected readonly ConfigurationService $service)
    {
        $this->middleware(Authenticate::class);
    }

    public function update(ConfigurationUpdateRequest $request, int $id): JsonResponse
    {
        return $this->doUpdate($request, $id);
    }
}
