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
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'genre' => $this->genre,
            'rating' => $this->rating,
            'episodes' => $this->episodes,
            'studio' => $this->studio,
            'collected_by' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
