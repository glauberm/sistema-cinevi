<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property UserModel $resource
 */
class User extends JsonResource
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
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'password' => $this->resource->password,
            'phone' => $this->resource->phone,
            'identifier' => $this->resource->identifier,
            'is_enabled' => $this->resource->is_enabled,
            'is_confirmed' => $this->resource->is_confirmed,
            'roles' => $this->resource->roles,
        ];
    }
}
