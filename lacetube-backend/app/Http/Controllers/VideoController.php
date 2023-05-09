<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForDownloading;
use App\Jobs\ConvertVideoForStreaming;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function getVideo($id): JsonResponse
    {
        return response()->json(Video::findOrFail($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request)
    {
        $video = Video::create([
            'disk'          => 'local',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $request->video->store('videos', 'local'),
            'title'         => $request->title,
            'description' => $request->description,
            
            'activity_id' => $request->activity_id,
            'user_id' => $request->user_id,
        ]);

        
        //$this->dispatch(new ConvertVideoForDownloading($video));
        ConvertVideoForDownloading::dispatch($video);
        //$this->dispatch(new ConvertVideoForStreaming($video));
        ConvertVideoForStreaming::dispatch($video);
        return response()->json([
            'id' => $video->id,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
