<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Configuration as ConfigurationModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ConfigurationModel $resource
 */
class Configuration extends JsonResource
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
            'bookings_are_closed' => $this->resource->bookings_are_closed,
            'bookings_forbidden_dates' => $this->resource->bookings_forbidden_dates,
            'bookings_create_or_update_emails' => $this->resource->bookings_create_or_update_emails,
            'final_copies_confirmation_message' => $this->resource->final_copies_confirmation_message,
            'final_copies_create_emails' => $this->resource->final_copies_create_emails,
            'final_copies_confirmed_emails' => $this->resource->final_copies_confirmed_emails,
        ];
    }
}
