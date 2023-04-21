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
            'name' => $this->name,
            'description' => $this->description,
            'mediaURL' => $this->mediaURL,
            'activity_id' => $this->activity_id,
            'teacher' => $this->activity->course->teacher,
            'created_at' => $this->created_at,
        ];
    }
}
