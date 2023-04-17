<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVideos extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'mediaURL' => $this->mediaURL,
            'activity' => $this->activity,
            'user' => $this->user,
            'teacher' => $this->activity->course->teacher,
            'created_at' => $this->created_at,
        ];
    }
}
