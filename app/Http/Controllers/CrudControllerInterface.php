<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RemoveRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface CrudControllerInterface
{
    /**
     * @param  Request             $request
     * @return ResourceCollection
     */
    public function paginate(Request $request): ResourceCollection;

    /**
     * @param FormRequest    $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse;

    /**
     * @param Request        $request
     * @param integer        $id
     * @return JsonResource
     */
    public function show(Request $request, int $id): JsonResource;

    /**
     * @param FormRequest    $request
     * @param integer        $id
     * @return JsonResponse
     */
    public function update(FormRequest $request, int $id): JsonResponse;

    /**
     * @param  RemoveRequest  $request
     * @param  integer        $id
     * @return JsonResponse
     */
    public function remove(RemoveRequest $request, int $id): JsonResponse;
}
