<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
            'streamingPath' => url('/api/streaming/'.$this->streaming_path),
            'downloadPath' => Storage::disk('download')->url($this->video_name.'/'.$this->downloadPath),
            'thumbnailURL' => Storage::disk('thumbnails')->url($this->thumbnailPath),
        ];
    }
}
