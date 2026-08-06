<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'url' => $this->path,
            'type' => $this->content_type,
            'info' => $this->description,
            'user_id(For Dbg)' => $this->user_id,
            'user' => $this->whenLoaded('user', fn() => new UserResource($this->user)),
            'category' => $this->whenLoaded('category', fn() => new CategoryResource($this->category)),
            'tags' => $this->whenLoaded('tags', fn() => TagResource::collection($this->tags)),
            'size_in_bytes' => $this->byte_size,
            'metadata' => $this->metadata,
            'is_favorite' => $this->is_favorite,
            'uploaded_on' => $this->created_at
        ];
    }
}
