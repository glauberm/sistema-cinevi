<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\FinalCopy as FinalCopyModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FinalCopyModel $resource
 */
class FinalCopy extends JsonResource
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
            'capture_format' => $this->resource->capture_format,
            'capture_notes' => $this->resource->capture_notes,
            'venues' => $this->resource->venues,
            'video_url' => $this->resource->video_url,
            'video_password' => $this->resource->video_password,
            'chromia' => $this->resource->chromia,
            'proportion' => $this->resource->proportion,
            'format' => $this->resource->format,
            'duration' => $this->resource->duration,
            'native_digital_format' => $this->resource->native_digital_format,
            'codec' => $this->resource->codec,
            'container' => $this->resource->container,
            'bitrate' => $this->resource->bitrate,
            'fps' => $this->resource->fps,
            'sound' => $this->resource->sound,
            'digital_sound_resolution' => $this->resource->digital_sound_resolution,
            'digital_matrix_support' => $this->resource->digital_matrix_support,
            'camera' => $this->resource->camera,
            'editing_software' => $this->resource->editing_software,
            'sound_capture_equipment' => $this->resource->sound_capture_equipment,
            'budget' => $this->resource->budget,
            'financing_sources' => $this->resource->financing_sources,
            'supporters' => $this->resource->supporters,
            'has_dcp' => $this->resource->has_dcp,
            'cast' => $this->resource->cast,
            'participations' => $this->resource->participations,
            'prizes' => $this->resource->prizes,
            'confirmed' => $this->resource->confirmed,
            'owner' => User::make($this->whenLoaded('owner')),
            'production_category' => ProductionCategory::make($this->whenLoaded('productionCategory')),
            'professor' => User::make($this->whenLoaded('professor')),
            'project' => Project::make($this->whenLoaded('project')),
            'production_roles' => FinalCopyProductionRole::collection($this->whenLoaded('productionRoles')),
        ];
    }
}
