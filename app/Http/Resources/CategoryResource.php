<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'user_id(For Dbg)' => $this->user_id,
            'is_private(For Dbg)' => $this->is_private,
            'user' => $this->whenLoaded('user', fn() => new UserResource($this->user))
        ];
    }
}
