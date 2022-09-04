<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ConfigurationUpdateRequest;
use App\Http\Resources\Configuration;
use App\Services\ConfigurationService;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ConfigurationController extends Controller implements CrudControllerInterface, HasVersionsControllerInterface
{
    use CrudControllerTrait, HasVersionsControllerTrait;

    protected string $resourceClass = Configuration::class;

    protected ConfigurationService $service;

    public function __construct(ConfigurationService $service)
    {
        $this->service = $service;

        $this->middleware(Authenticate::class . ':sanctum');
    }

    /**
     * @param  ConfigurationUpdateRequest  $request
     * @param  integer                     $id
     * @return JsonResponse
     */
    public function doUpdate(ConfigurationUpdateRequest $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }
}
