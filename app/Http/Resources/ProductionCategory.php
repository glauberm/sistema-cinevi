<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\ProductionCategory as ProductionCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ProductionCategoryModel $resource
 */
class ProductionCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
        ];
    }
}
