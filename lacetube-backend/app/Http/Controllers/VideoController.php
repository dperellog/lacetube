<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Resources\UserVideosResource;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
