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
    public function paginate(Request $request): ResourceCollection;

    public function doCreate(FormRequest $request): JsonResponse;

    public function show(Request $request, int $id): JsonResource;

    public function doUpdate(FormRequest $request, int $id): JsonResponse;

    public function doRemove(FormRequest $request, int $id): JsonResponse;
}
