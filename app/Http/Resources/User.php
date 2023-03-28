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
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'identifier' => $this->resource->identifier,
            'is_enabled' => $this->resource->is_enabled,
            'is_confirmed' => $this->resource->is_confirmed,
            'roles' => $this->resource->roles,
        ];
    }
}
