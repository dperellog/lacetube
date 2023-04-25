<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVideosResource extends JsonResource
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
            'user' => $this->user,
            'name' => $this->name,
            'description' => $this->description,
            'mediaURL' => $this->mediaURL,
            'activity' => $this->activity,
            'comments' => $this->comments,
            'teacher' => $this->teacher,
            'created_at' => $this->created_at,
        ];
    }
}
