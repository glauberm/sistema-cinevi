<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\FinalCopyProductionRole as FinalCopyProductionRoleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FinalCopyProductionRoleModel $resource
 */
class FinalCopyProductionRole extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string,mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'production_role' => ProductionRole::make($this->resource->productionRole),
            'users' => User::collection($this->resource->users),
        ];
    }
}
