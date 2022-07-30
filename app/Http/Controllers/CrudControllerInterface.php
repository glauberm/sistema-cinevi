<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface CrudControllerInterface
{
    /**
     * Mostra uma coleção de recursos.
     *
     * @param  Request            $request
     * @return ResourceCollection
     */
    public function paginate(Request $request): ResourceCollection;

    /**
     * Adiciona um recurso.
     *
     * @param FormRequest $request
     * @return JsonResponse
     */
    public function create(FormRequest $request): JsonResponse;

    /**
     * Mostra um recurso.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResource
     */
    public function show(Request $request, int $id): JsonResource;

    /**
     * Atualiza um recurso.
     *
     * @param FormRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(FormRequest $request, int $id): JsonResponse;

    /**
     * Remove um recurso.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id): JsonResponse;
}
