<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface HasVersionsControllerInterface
{
    /**
     * Mostra uma coleção de versões de um item.
     *
     * @param Request $request
     * @param int $id
     * @return ResourceCollection
     */
    public function paginateVersions(Request $request, int $id): ResourceCollection;

    /**
     * Mostra uma versão de um item.
     *
     * @param Request $request
     * @param int $id
     * @return Version
     */
    public function showVersion(Request $request, int $id): Version;
}
