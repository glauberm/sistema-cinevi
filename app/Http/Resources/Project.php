<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Project as ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ProjectModel $resource
 */
class Project extends JsonResource
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'synopsis' => $this->resource->synopsis,
            'genres' => $this->resource->genres,
            'capture_format' => $this->resource->capture_format ?? '',
            'capture_notes' => $this->resource->capture_notes ?? '',
            'venues' => $this->resource->venues ?? '',
            'pre_production_date' => $this->resource->pre_production_date->format('Y-m-d'),
            'production_date' => $this->resource->production_date->format('Y-m-d'),
            'post_production_date' => $this->resource->post_production_date->format('Y-m-d'),
            'has_attended_photography_discipline' => $this->resource->has_attended_photography_discipline,
            'has_attended_sound_discipline' => $this->resource->has_attended_sound_discipline,
            'has_attended_art_discipline' => $this->resource->has_attended_art_discipline,
            'owner' => User::make($this->whenLoaded('owner')),
            'production_category' => ProductionCategory::make($this->whenLoaded('productionCategory')),
            'professor' => User::make($this->whenLoaded('professor')),
            'directors' => User::collection($this->whenLoaded('directors')),
            'producers' => User::collection($this->whenLoaded('producers')),
            'photography_directors' => User::collection($this->whenLoaded('photographyDirectors')),
            'sound_directors' => User::collection($this->whenLoaded('soundDirectors')),
            'art_directors' => User::collection($this->whenLoaded('artDirectors')),
        ];
    }
}