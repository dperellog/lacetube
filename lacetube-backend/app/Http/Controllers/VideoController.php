<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Resources\UserVideosResource;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function getVideo($id): JsonResponse
    {
        return response()->json(new UserVideosResource(Video::findOrFail($id)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {

        //Guardar video temporalment:
        $tempPath = $request->video->store('', 'tmp');
        $videoName = explode('.',$tempPath)[0];

        //Processar video:
        //ConvertVideoForDownloading::dispatch($tempPath, $videoName);
        ConvertVideoForStreaming::dispatch($tempPath, $videoName);


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

        Storage::disk('tmp')->delete($tempPath);
        return response()->json(new UserVideosResource($video), 201);
    }

    /**
     * Display the specified resource.
     */
    public function stream(string $file)
    {
        $contents = file_get_contents(Storage::disk('streaming')->path($file));
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'application/vnd.apple.mpegurl');
        return $response;

        //
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, string $id)
     {
        $video=Video::findOrFail($id);
        if (Auth::user()->id != $video->user->id){
            return response()->json('',401);
        }
        $validateData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        $video->title = $request->title;
        $video->description = $request->description;
        $video->save();
        return response()->json($video, 201);
     }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video=Video::findOrFail($id);
        if (Auth::user()->id != $video->user->id && Auth::user()->id != $video->teacher->id && !User::find(Auth::user()->id)->hasRole('admin')){
            return response()->json('',401);
        }
        Storage::disk('download')->deleteDirectory($video->video_name);
        Storage::disk('streaming')->deleteDirectory($video->video_name);
        $video->delete();
        return response()->json(null, 204);

    }

}
