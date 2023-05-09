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
            'activity' => $this->activity,
            'comments' => $this->comments,
            'title' => $this->title,
            'description' => $this->description,
            'path' => $this->path,
            
        ];
    }
}
