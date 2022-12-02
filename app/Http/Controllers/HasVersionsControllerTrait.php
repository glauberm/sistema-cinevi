<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait HasVersionsControllerTrait
{
    public function paginateVersions(Request $request, int $id): ResourceCollection
    {
        return Version::collection($this->service->paginateVersions($id));
    }

    public function showVersion(Request $request, int $id): Version
    {
        return new Version($this->service->getVersion($id));
    }
}
