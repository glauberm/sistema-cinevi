<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface CrudControllerInterface
{
    public function paginate(Request $request): View;

    public function doCreate(FormRequest $request): RedirectResponse;

    public function doUpdate(FormRequest $request, int $id): RedirectResponse;

    public function doRemove(FormRequest $request, int $id): RedirectResponse;
}
