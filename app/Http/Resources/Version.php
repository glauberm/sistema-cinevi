<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Version as VersionModel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property VersionModel $resource
 */
class Version extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'action' => $this->resource->action,
            'message' => $this->resource->message,
            'user' => $this->getUser(),
            'user_agent' => $this->resource->user_agent,
            'user_ip' => $this->resource->user_ip,
            'payload' => $this->resource->payload,
            'created_at' => $this->resource->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return JsonResource|string
     */
    public function getUser(): JsonResource|string
    {
        if ($this->resource->user !== null) {
            return User::make($this->resource->user);
        }

        if ($this->resource->user_string === 'not_authenticated') {
            return 'Usuário não autenticado';
        }

        return $this->resource->user_string;
    }
}
