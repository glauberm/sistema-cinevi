<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Booking as BookingModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property BookingModel $resource
 */
class Booking extends JsonResource
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
            'withdrawal_date' => $this->resource->withdrawal_date->format('Y-m-d'),
            'devolution_date' => $this->resource->devolution_date->format('Y-m-d'),
            'owner' => User::make($this->whenLoaded('owner')),
            'project' => Project::make($this->whenLoaded('project')),
            'bookables' => Bookable::collection($this->whenLoaded('bookables')),
        ];
    }
}
