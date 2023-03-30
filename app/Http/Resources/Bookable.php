<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Bookable as BookableModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property BookableModel $resource
 */
class Bookable extends JsonResource
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'identifier' => $this->resource->identifier,
            'name' => $this->resource->name,
            'inventory_number' => $this->resource->inventory_number ?? '',
            'serial_number' => $this->resource->serial_number ?? '',
            'accessories' => $this->resource->accessories ?? '',
            'notes' => $this->resource->notes ?? '',
            'is_under_maintenance' => $this->resource->is_under_maintenance,
            'is_return_overdue' => $this->resource->is_return_overdue,
            'bookable_category' => BookableCategory::make($this->whenLoaded('bookableCategory')),
            'users' => User::collection($this->whenLoaded('users')),
            'bookings' => Booking::collection($this->whenLoaded('bookings')),
        ];
    }
}