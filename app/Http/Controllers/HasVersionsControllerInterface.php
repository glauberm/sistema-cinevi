<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface HasVersionsControllerInterface
{
    /**
     * @param Request              $request
     * @param integer              $id
     * @return ResourceCollection
     */
    public function paginateVersions(Request $request, int $id): ResourceCollection;

    /**
     * @param Request   $request
     * @param integer   $id
     * @return Version
     */
    public function showVersion(Request $request, int $id): Version;
}
