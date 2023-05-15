<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'stars' => $this->stars,
            'description' => $this->description,
            'published_at' => $this->created_at,
            'user' => new UserSimpleResource($this->user),
            'isTeacher' => $this->isTeacher,
            'video_id' => $this->video_id
        ];
    }
}
