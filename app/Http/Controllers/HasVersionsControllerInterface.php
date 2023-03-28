<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

interface HasVersionsControllerInterface
{
    public function paginateVersions(Request $request, int $id): View;

    public function showVersion(Request $request, int $id): View;
}
