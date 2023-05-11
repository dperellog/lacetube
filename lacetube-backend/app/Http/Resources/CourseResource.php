<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CourseResource extends JsonResource
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
            'thumbnailURL' => Storage::disk('thumbnails')->url($this->thumbnailURL),
            'year' => $this->year,
            'students' => $this->students,
            'teacher' => $this->teacher,
            'parent' => $this->parent,
        ];
    }
}
