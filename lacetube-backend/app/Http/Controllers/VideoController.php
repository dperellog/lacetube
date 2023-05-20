<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Resources\UserVideosResource;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Activity;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Get video by id
     */
    public function getVideo($id): JsonResponse
    {
        return response()->json(new UserVideosResource(Video::findOrFail($id)));
    }

    /**
     * Get video by task id
     */
    public function getByTask($id)
    {
        // If no task is provided, get all videos.
        if ($id == 0) {
            return response()->json(UserVideosResource::collection(Video::all()));
        }else{
            $task = Activity::findOrFail($id);
            return response()->json(UserVideosResource::collection($task->videos));
        }
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        // Data comes validated from "StoreVideoRequest" object.

        // Store video file temporally
        $tempPath = $request->video->store('', 'tmp');
        $videoName = explode('.',$tempPath)[0];

        // Process video for streaming:
        ConvertVideoForStreaming::dispatch($tempPath, $videoName);

        // Process video for downloading:
        #ConvertVideoForDownloading::dispatch($tempPath, $videoName);

        // Store video metadada to DB.
        $video = Video::create([
            'title'         => $request->title,
            'description' => $request->description,
            'activity_id' => $request->activity_id,
            'user_id' => $request->user_id,
            'video_name' => $videoName,
            'streamingPath' => $videoName.'.m3u8',
            'downloadPath' => $videoName.'.mp4',
            'thumbnailPath' => $videoName.'_thumbnail.jpg'
        ]);

        // Delete temporal video file.
        Storage::disk('tmp')->delete($tempPath);
        return response()->json(new UserVideosResource($video), 201);
    }

    /**
     * Update the specified video in storage.
     */
     public function update(Request $request, string $id)
     {
        // Get the video.
        $video=Video::findOrFail($id);

        // Check if requested user is the owner.
        if (Auth::user()->id != $video->user->id){
            return response()->json('',401);
        }

        // Validate data.
        $validateData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        // Update the video metadata.
        $video->title = $request->title;
        $video->description = $request->description;
        $video->save();
        return response()->json($video, 201);
     }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(string $id)
    {
        // Get the video.
        $video=Video::findOrFail($id);

        // Check if user has permissions (Is the owner, the teacher or admin).
        if (Auth::user()->id != $video->user->id && Auth::user()->id != $video->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            // If has no permission, fail.
            return response()->json('',401);
        }

        // Delete video and thumbnail.
        Storage::disk('download')->deleteDirectory($video->video_name);
        Storage::disk('streaming')->deleteDirectory($video->video_name);
        Storage::disk('thumbnails')->delete('' . $video->thumbnailPath);
        $video->delete();

        return response()->json(null, 204);

    }

}
