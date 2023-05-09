<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ActivityResource extends JsonResource
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
            'end_date' => $this->end_date,
            'course' => $this->course,
            'students' => $this->students,
            'teacher' => $this->teacher,
            'videos' => $this->videos,
            'entregada' => $this->entregada($this->id),
        ];
    }
    public function entregada($id){
        
        $videos=Video::where('activity_id', $id)
        ->where('user_id', Auth::user()->id)
        ->get();
        if ($videos->isEmpty()){
            return false;
        }else{
            return $videos[0];
        }
        
    }
}
