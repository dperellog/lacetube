<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCourseResource extends JsonResource
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
            'thumbnailURL' => $this->thumbnailURL,
            'year' => $this->year,
            'students' => $this->students,
            'teacher' => $this->teacher,
            'parent' => $this->parent,
        ];
    }
}
